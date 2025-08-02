<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddTransactionNotification extends Notification
{
    use Queueable;
    private $transaction_data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transaction_data)
    {
        $this->transaction_data = $transaction_data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject($this->transaction_data['transaction_type'] == 'withdraw' ? 'Withdrawal Requested' : 'Deposit Successful')
            ->view('admin.emails.add_transaction_email', ["transaction_data" => $this->transaction_data]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
