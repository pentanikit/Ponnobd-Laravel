<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNewOrderMail;
use App\Mail\OrderReceiptMail;

class SendOrderEmails
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        // Eager load relations used in emails
        $order = $event->order->loadMissing(['items.product', 'user']);

        // Send receipt to customer
        $customerEmail = $order->email ?? optional($order->user)->email;
        if ($customerEmail) {
            Mail::to($customerEmail)->queue(new OrderReceiptMail($order));
            // If you don't want queues, use ->send(...) instead of ->queue(...)
        }

        // Send alert to admin
        $adminEmail = config('shop.admin_email', env('ORDER_ADMIN_EMAIL'));
        if ($adminEmail) {
            Mail::to($adminEmail)->queue(new AdminNewOrderMail($order));
        }
    }
}
