<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAuditLog;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('creator')->latest()->paginate(20);

        return view('Admin.Announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'message'    => 'required|string|max:1000',
            'type'       => 'required|in:info,warning,danger,success',
            'expires_at' => 'nullable|date|after:now',
        ]);

        // Deactivate existing active ones first (only one active at a time)
        Announcement::where('active', true)->update(['active' => false]);

        $announcement = Announcement::create([
            'message'    => $data['message'],
            'type'       => $data['type'],
            'active'     => true,
            'expires_at' => $data['expires_at'] ?? null,
            'created_by' => auth()->id(),
        ]);

        Cache::forget('active_announcement');

        AdminAuditLog::record('create_announcement', 'announcement', $announcement->id, [
            'type' => $data['type'], 'message' => substr($data['message'], 0, 100),
        ]);

        return back()->with('success', 'Announcement published.');
    }

    public function deactivate(Announcement $announcement)
    {
        $announcement->update(['active' => false]);
        Cache::forget('active_announcement');

        AdminAuditLog::record('deactivate_announcement', 'announcement', $announcement->id, []);

        return back()->with('success', 'Announcement deactivated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        Cache::forget('active_announcement');

        AdminAuditLog::record('delete_announcement', 'announcement', $announcement->id, []);

        return back()->with('success', 'Announcement deleted.');
    }
}
