<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderData extends Mailable
{
    use Queueable, SerializesModels;

    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->from('no-reply@example.com', 'LaravelApp')
            ->view('emails.order.data')
            ->text('emails.order.data_plain_text')
            ->with([
                'order' => $this->order,
                'first_name' => $this->order->first_name,
            ])
            ->attach(Storage::path('file1.jpg'), [
                'as' => 'file_new.jpg',
            ])
            ->subject('Order Id: '. $this->order->id)
            ->tag('order')
        ;
    }
}
