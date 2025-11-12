<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue; // <-- REMOVED
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class OrderPlaced extends Mailable // <-- REMOVED 'implements ShouldQueue'
{
    use SerializesModels; // <-- REMOVED 'Queueable'

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bloombeads Order Confirmation #' . $this->order->order_tracking_id,
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.orders.placed',
        );
    }
}