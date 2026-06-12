<?php

namespace App\Observers;

use App\Models\ErrorTicket;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ErrorTicketObserver
{
    public function created(ErrorTicket $ticket): void
    {
        try {
            Mail::raw("
                🚨 New Error Logged:
                Type: {$ticket->error_type}
                Message: {$ticket->message}
                File: {$ticket->file} (Line: {$ticket->line})
                URL: {$ticket->url}
                IP: {$ticket->ip_address}
                User Agent: {$ticket->user_agent}
                User ID: {$ticket->user_id}
            ", function ($message) {
                $message->to('support@brightfinance-x.co.za')->subject('🚨 New Error Ticket');
            });
        } catch (\Throwable $e) {
            Log::warning("Error notification email failed: " . $e->getMessage());
        }
    }

    public function creating(ErrorTicket $ticket): void {}
    public function updated(ErrorTicket $ticket): void {}
    public function deleted(ErrorTicket $ticket): void {}
    public function restored(ErrorTicket $ticket): void {}
    public function forceDeleted(ErrorTicket $ticket): void {}
}
