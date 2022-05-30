<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    private Order $order;
    private string $orderUrl;

    public function __construct(Order $order, string $orderUrl)
    {
        $this->order = $order;
        $this->orderUrl = $orderUrl;
    }

    public function build()
    {
        return $this->from('no-reply@example.com')
            ->subject(sprintf('Order no.: %s was shipped', $this->order->id))
            ->bcc('m.galvanauskas@gmail.com')
            ->markdown('emails.order.shipped', [
                'order' => $this->order,
                'url' => $this->orderUrl,
            ]);
    }
}
