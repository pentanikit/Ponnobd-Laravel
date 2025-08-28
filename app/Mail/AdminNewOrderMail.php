<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use Symfony\Component\Mime\Address;

class AdminNewOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;

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
        // build subject
        $num  = $this->order->order_number ?? $this->order->id;
        $name = $this->order->billing_name
            ?? optional($this->order->user)->name
            ?? 'Customer';

        // parse ADMIN_EMAIL (comma-separated supported)
        $raw = (string) config('mail.admin_address', '');
        $to = collect(explode(',', $raw))
            ->map(fn ($e) => trim($e))
            ->filter(fn ($e) => filter_var($e, FILTER_VALIDATE_EMAIL))
            ->map(fn ($e) => new Address($e))
            ->all();

        return new Envelope(
            to: $to, // ✅ ensures a To header exists
            subject: "New order #{$num} from {$name}"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.admin_new',
            with: ['order' => $this->order]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
