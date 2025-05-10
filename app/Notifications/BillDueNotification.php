<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BillDueNotification extends Notification
{
    use Queueable;
    protected $bill;

       /**
     * Create a new notification instance.
     *
     * @param Budget $bill The overdue bill to include in the notification.
     */
    public function __construct(Budget $bill)
    {
        $this->bill = $bill;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Hello, ' . $notifiable->name) // Include the recipient's name
            ->line('This is a reminder about an overdue bill:')
            ->line('Bill Description: ' . $this->bill->Description)
            ->line('Amount: R' . number_format($this->bill->Amount, 2)) // Format amount as currency
            ->line('Due Date: ' . $this->bill->due_date)
            ->action('View Bill', url('/link-to-view-bill')) // Provide a link to view the bill
            ->line('Thank you for using our application!');
    }
    
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'bill_description' => $this->bill->Description,
            'amount' => $this->bill->Amount,
            'due_date' => $this->bill->due_date,
            'bill_link' => url('/link-to-view-bill'), // You can include a link to view the bill here too
        ];
    }
}
