<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue; // <-- REMOVED
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrderNotification extends Mailable // <-- REMOVED 'implements ShouldQueue'
{
    use SerializesModels; // <-- REMOVED 'Queueable'

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order Received! #' . $this->order->order_tracking_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.new_order_alert',
        );
    }
}