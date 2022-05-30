<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderStatus extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private Order $order;
    private string $myName;

    public function __construct(Order $order, $myName)
    {
        $this->order = $order;
        $this->myName = $myName;
    }

    public function build()
    {
        return $this->markdown('emails.order.status')
            ->with([
                'order' => $this->order,
                'myName' => $this->myName,
            ])
            ->subject('Order status notification')
            ->bcc('Petras@example.com')
        ;
    }
}
