<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BudgetReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly object $user,
        public readonly \Illuminate\Support\Collection $upcomingBudgets,
        public readonly \Illuminate\Support\Collection $upcomingMilestones,
    ) {}

    public function envelope(): Envelope
    {
        $count = $this->upcomingBudgets->count() + $this->upcomingMilestones->count();
        return new Envelope(
            subject: "Bright Finance — You have {$count} item(s) due soon",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.budget-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
