<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\Journal_entry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Statements.import');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'statement' => 'required|file|mimes:csv,txt|max:4096',
            'bank'      => 'required|string',
        ]);

        $file = $request->file('statement');
        $bank = $request->bank;

        // Read raw file and detect delimiter
        $raw = file_get_contents($file->getRealPath());
        $lines = array_filter(explode("\n", str_replace("\r\n", "\n", $raw)));
        $lines = array_values($lines);

        if (count($lines) < 2) {
            return back()->with('error', 'The file appears to be empty or has only a header row.');
        }

        // Detect delimiter: comma or semicolon
        $sample = $lines[0];
        $commas     = substr_count($sample, ',');
        $semicolons = substr_count($sample, ';');
        $delimiter  = $semicolons > $commas ? ';' : ',';

        // Parse header
        $headers = array_map('trim', str_getcsv($lines[0], $delimiter));

        // Parse all rows
        $rows = [];
        for ($i = 1; $i < count($lines); $i++) {
            $cols = str_getcsv($lines[$i], $delimiter);
            if (count(array_filter($cols)) === 0) continue;
            // Pad short rows
            while (count($cols) < count($headers)) $cols[] = '';
            $rows[] = array_combine($headers, array_map('trim', $cols));
        }

        if (empty($rows)) {
            return back()->with('error', 'No data rows found after the header.');
        }

        // Auto-detect column mapping based on common bank formats
        $mapping = $this->detectMapping($headers, $bank);

        // Store in session for preview step
        session([
            'stmt_rows'    => $rows,
            'stmt_headers' => $headers,
            'stmt_mapping' => $mapping,
            'stmt_bank'    => $bank,
            'stmt_count'   => count($rows),
        ]);

        return redirect()->route('statements.preview');
    }

    public function preview(Request $request)
    {
        if (!session()->has('stmt_rows')) {
            return redirect()->route('statements.import')->with('error', 'No statement uploaded. Please start again.');
        }

        $rows    = session('stmt_rows');
        $headers = session('stmt_headers');
        $mapping = session('stmt_mapping');
        $bank    = session('stmt_bank');

        // Load user categories for the categorisation dropdowns
        $categories = Category::where('Added_by', Auth::id())
            ->orderBy('Nature')->orderBy('category')
            ->get();

        // Auto-suggest category for each row based on description keywords
        $suggestions = [];
        foreach ($rows as $i => $row) {
            $desc = strtolower($row[$mapping['description']] ?? '');
            $suggestions[$i] = $this->suggestCategory($desc, $categories);
        }

        return view('Statements.preview', compact(
            'rows', 'headers', 'mapping', 'bank', 'categories', 'suggestions'
        ));
    }

    public function confirm(Request $request)
    {
        if (!session()->has('stmt_rows')) {
            return redirect()->route('statements.import')->with('error', 'Session expired. Please upload again.');
        }

        $rows    = session('stmt_rows');
        $mapping = $request->input('mapping', session('stmt_mapping'));

        $dateCol  = $mapping['date'];
        $descCol  = $mapping['description'];
        $amtCol   = $mapping['amount']   ?? null;
        $debitCol = $mapping['debit']    ?? null;
        $creditCol= $mapping['credit']   ?? null;

        $rowCategories = $request->input('categories', []);
        $rowSkip       = $request->input('skip', []);

        $userId    = Auth::id();
        $imported  = 0;
        $skipped   = 0;
        $duplicate = 0;

        DB::beginTransaction();
        try {
            foreach ($rows as $i => $row) {
                if (isset($rowSkip[$i])) { $skipped++; continue; }

                $catId = $rowCategories[$i] ?? null;
                if (!$catId) { $skipped++; continue; }

                // Parse date
                $rawDate = trim($row[$dateCol] ?? '');
                try {
                    $date = Carbon::parse($rawDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    $skipped++; continue;
                }

                // Parse amount
                if ($amtCol) {
                    $raw = $this->cleanAmount($row[$amtCol] ?? '0');
                    $amount = abs($raw);
                    $action = $raw < 0 ? 'Paid' : 'Received';
                } else {
                    $debit  = $this->cleanAmount($row[$debitCol]  ?? '0');
                    $credit = $this->cleanAmount($row[$creditCol] ?? '0');
                    if ($debit > 0) {
                        $amount = $debit; $action = 'Paid';
                    } else {
                        $amount = $credit; $action = 'Received';
                    }
                }

                if ($amount <= 0) { $skipped++; continue; }

                $description = trim($row[$descCol] ?? 'Bank Statement Import');

                // Duplicate check: same user + date + amount + description
                $exists = Transaction::where('Added_by', $userId)
                    ->where('bill_date', $date)
                    ->where('amount', $amount)
                    ->where('description', $description)
                    ->exists();

                if ($exists) { $duplicate++; continue; }

                // Create transaction
                $t = Transaction::create([
                    'Action'      => $action,
                    'Category'    => $catId,
                    'Description' => $description,
                    'Amount'      => $amount,
                    'Method'      => 'Bank Statement',
                    'bill_date'   => $date,
                    'Status'      => 'Paid',
                    'Added_by'    => $userId,
                    'FY'          => Carbon::parse($date)->year,
                ]);

                // Update category balance
                $cat = Category::find($catId);
                if ($cat) {
                    $delta = in_array($action, ['Received', 'Earned']) ? $amount : -$amount;
                    $cat->Balance = ($cat->Balance ?? 0) + $delta;
                    $cat->save();
                }

                // Bank (Dr) counter-entry
                $bank = Category::where('Added_by', $userId)->where('category', 'Bank (Dr)')->first();
                if ($bank) {
                    $bankDelta = $action === 'Paid' ? -$amount : $amount;
                    $bank->Balance = ($bank->Balance ?? 0) + $bankDelta;
                    $bank->save();
                }

                $imported++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('statements.preview')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }

        // Clear session
        session()->forget(['stmt_rows', 'stmt_headers', 'stmt_mapping', 'stmt_bank', 'stmt_count']);

        return redirect()->route('transactions.index')
            ->with('success', "Import complete — {$imported} transactions added, {$duplicate} duplicates skipped, {$skipped} rows skipped.");
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function detectMapping(array $headers, string $bank): array
    {
        $lower = array_map('strtolower', $headers);
        $flip  = array_flip($lower);

        $find = function (array $candidates) use ($flip, $lower) {
            foreach ($candidates as $c) {
                if (isset($flip[$c])) return $headers[$flip[$c]];
                foreach ($lower as $i => $h) {
                    if (str_contains($h, $c)) return $headers[$i];
                }
            }
            return null;
        };

        // Bank-specific known formats
        $presets = [
            'fnb'          => ['date'=>'Date','description'=>'Description','amount'=>'Amount'],
            'standard_bank'=> ['date'=>'Date','description'=>'Description','debit'=>'Debit Amount','credit'=>'Credit Amount'],
            'absa'         => ['date'=>'Date','description'=>'Description','debit'=>'Debit','credit'=>'Credit'],
            'nedbank'      => ['date'=>'Date','description'=>'Transaction Description','amount'=>'Amount'],
            'capitec'      => ['date'=>'Date','description'=>'Transaction','debit'=>'Debit','credit'=>'Credit'],
        ];

        if (isset($presets[$bank])) {
            $p = $presets[$bank];
            return [
                'date'        => $find([$p['date']  ?? 'date']),
                'description' => $find([$p['description'] ?? 'description']),
                'amount'      => $find([$p['amount'] ?? '']),
                'debit'       => $find([$p['debit']  ?? '']),
                'credit'      => $find([$p['credit'] ?? '']),
            ];
        }

        // Generic auto-detect
        return [
            'date'        => $find(['date', 'transaction date', 'trans date', 'posting date']),
            'description' => $find(['description', 'narrative', 'details', 'transaction', 'memo']),
            'amount'      => $find(['amount', 'value']),
            'debit'       => $find(['debit', 'debit amount', 'withdrawal']),
            'credit'      => $find(['credit', 'credit amount', 'deposit']),
        ];
    }

    private function suggestCategory(string $desc, $categories): ?int
    {
        $keywords = [
            'salary'    => ['salary', 'wage', 'payroll', 'remuneration'],
            'groceries' => ['shoprite', 'checkers', 'pick n pay', 'pnp', 'woolworths food', 'spar', 'grocery'],
            'fuel'      => ['engen', 'bp ', 'shell', 'caltex', 'total', 'fuel', 'petrol'],
            'rent'      => ['rent', 'landlord', 'lease'],
            'telephone' => ['vodacom', 'mtn', 'cell c', 'telkom', 'airtime', 'data'],
            'water'     => ['municipality', 'eskom', 'water', 'electricity', 'rates'],
            'transport' => ['uber', 'bolt', 'taxi', 'bus', 'transport'],
            'entertainment' => ['netflix', 'dstv', 'showmax', 'spotify', 'cinema', 'movies'],
        ];

        foreach ($keywords as $catName => $terms) {
            foreach ($terms as $term) {
                if (str_contains($desc, $term)) {
                    $match = $categories->first(fn($c) => str_contains(strtolower($c->category), $catName));
                    if ($match) return $match->id;
                }
            }
        }

        return null;
    }

    private function cleanAmount(string $raw): float
    {
        // Remove currency symbols, spaces, thousands separators
        $clean = preg_replace('/[^0-9.\-]/', '', str_replace(',', '', $raw));
        return (float) $clean;
    }
}
