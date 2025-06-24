<?php

namespace App\Observers;

use App\Models\ErrorTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorTicketMail;

class ErrorTicketObserver
{
    /**
     * Handle the ErrorTicket "created" event.
     */
    public function created(ErrorTicket $errorTicket): void
    {
        //
    }
     public function creating(ErrorTicket $ticket)
    {
        // Log it as fallback
        Log::info("📨 Preparing to send error report email");

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
                $message->to('support@yourdomain.com')->subject('🚨 New Error Ticket');
            });
        } catch (\Throwable $e) {
            Log::error("❌ Failed to email error: " . $e->getMessage());
        }
    }

    /**
     * Handle the ErrorTicket "updated" event.
     */
    public function updated(ErrorTicket $errorTicket): void
    {
        //
    }

    /**
     * Handle the ErrorTicket "deleted" event.
     */
    public function deleted(ErrorTicket $errorTicket): void
    {
        //
    }

    /**
     * Handle the ErrorTicket "restored" event.
     */
    public function restored(ErrorTicket $errorTicket): void
    {
        //
    }

    /**
     * Handle the ErrorTicket "force deleted" event.
     */
    public function forceDeleted(ErrorTicket $errorTicket): void
    {
        //
    }
}
