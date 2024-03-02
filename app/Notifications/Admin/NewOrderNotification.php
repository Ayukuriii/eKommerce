<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
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

        return (new MailMessage)
            ->subject('New Order Created')
            ->greeting('Hello')
            ->line('New order Id' . $this->order->id . ' has been created!')
            ->action('Detail Order', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Order Created',
            'category' => 'Order',
            'body' => 'New order Id' . $this->order->id . ' has been created!',
            'link' => "http://ekommerce.test/admin/orders/" . $this->order->id,
        ];
    }
}
