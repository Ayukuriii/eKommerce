<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MidtransNotification extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = "http://ekommerce.test/admin/orders/" . $this->order->id;
        $message = $this->orderMessage($this->order);

        return (new MailMessage)
            ->subject('Perubahan Status Order')
            ->greeting('Hello')
            ->line($message)
            ->action('Detail Order', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = $this->orderMessage($this->order);
        return [
            'title' => 'Perubahan Status Order',
            'category' => 'Midtrans',
            'body' => $message,
            'link' => "http://ekommerce.test/admin/orders/" . $this->order->id,
        ];
    }

    private function orderMessage($order)
    {
        if ($order->status == 'success') {
            $message = 'Order Id ' . $order->id . ' telah diselesaikan';
        } else {
            $message = 'Order Id ' . $order->id . ' gagal';
        }

        return $message;
    }
}
