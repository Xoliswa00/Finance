<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\User;
use App\Models\UserNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    public function changeRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:Master,AdmiX,friend']);

        // Protect against demoting the only Master
        if ($user->Role === 'Master' && $request->role !== 'Master') {
            $masterCount = User::where('Role', 'Master')->count();
            if ($masterCount <= 1) {
                return back()->withErrors(['role' => 'Cannot demote the only Master account.']);
            }
        }

        $old = $user->Role;
        $user->update(['Role' => $request->role]);

        AdminAuditLog::record('change_role', 'user', $user->id, [
            'from' => $old, 'to' => $request->role, 'email' => $user->email,
        ]);

        return back()->with('success', "{$user->name}'s role changed to {$request->role}.");
    }

    public function suspend(Request $request, User $user)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        if ($user->id === auth()->id()) {
            return back()->withErrors(['reason' => 'You cannot suspend your own account.']);
        }

        $user->update([
            'suspended_at'       => now(),
            'suspension_reason'  => $request->reason,
            'force_logout_at'    => now(),
        ]);

        AdminAuditLog::record('suspend_user', 'user', $user->id, [
            'reason' => $request->reason, 'email' => $user->email,
        ]);

        return back()->with('success', "{$user->name} has been suspended.");
    }

    public function reactivate(User $user)
    {
        $user->update(['suspended_at' => null, 'suspension_reason' => null]);

        AdminAuditLog::record('reactivate_user', 'user', $user->id, ['email' => $user->email]);

        return back()->with('success', "{$user->name}'s account has been reactivated.");
    }

    public function forceLogout(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot force-logout yourself.']);
        }

        $user->update(['force_logout_at' => now()]);

        AdminAuditLog::record('force_logout', 'user', $user->id, ['email' => $user->email]);

        return back()->with('success', "{$user->name} will be signed out on their next request.");
    }

    public function resetPassword(User $user)
    {
        $status = Password::sendResetLink(['email' => $user->email]);

        AdminAuditLog::record('reset_password', 'user', $user->id, ['email' => $user->email]);

        $message = $status === Password::RESET_LINK_SENT
            ? "Password reset email sent to {$user->email}."
            : "Could not send reset email. Check mail config.";

        return back()->with('success', $message);
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }

        if ($user->Role === 'Master') {
            return back()->withErrors(['error' => 'Master accounts cannot be deleted directly.']);
        }

        $email = $user->email;
        $name  = $user->name;

        // Anonymise rather than hard-delete to preserve audit trail integrity
        $user->update([
            'name'       => 'Deleted User',
            'Surname'    => '',
            'email'      => 'deleted_' . $user->id . '@removed.local',
            'Mobile'     => null,
            'Location'   => null,
            'password'   => Hash::make(Str::random(40)),
            'suspended_at' => now(),
        ]);

        AdminAuditLog::record('delete_user', 'user', $user->id, ['email' => $email, 'name' => $name]);

        return back()->with('success', "{$name} ({$email}) has been anonymised and deactivated.");
    }

    public function addNote(Request $request, User $user)
    {
        $request->validate(['note' => 'required|string|max:1000']);

        UserNote::create([
            'user_id'  => $user->id,
            'admin_id' => auth()->id(),
            'note'     => $request->note,
        ]);

        return back()->with('success', 'Note added.');
    }

    public function deleteNote(UserNote $note)
    {
        $note->delete();
        return back()->with('success', 'Note deleted.');
    }

    public function impersonate(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot impersonate yourself.']);
        }

        session(['impersonating_id' => auth()->id()]);

        AdminAuditLog::record('impersonate_start', 'user', $user->id, ['email' => $user->email]);

        Auth::loginUsingId($user->id, false);

        return redirect()->route('home')->with('status', 'You are now viewing as ' . $user->name . '.');
    }

    public function stopImpersonating()
    {
        $adminId = session('impersonating_id');

        if (!$adminId) {
            return redirect()->route('home');
        }

        AdminAuditLog::record('impersonate_stop', 'user', auth()->id(), []);

        session()->forget('impersonating_id');
        Auth::loginUsingId($adminId, false);

        return redirect()->route('admin.users')->with('success', 'Returned to your admin account.');
    }

    public function userActivity(User $user)
    {
        $logs         = $user->activityLogs()->paginate(50);
        $loginHistory = $user->loginAttempts()->limit(30)->get();
        $notes        = $user->notes()->with('admin')->get();

        return view('Admin.Users.UserActivity', compact('user', 'logs', 'loginHistory', 'notes'));
    }
}
