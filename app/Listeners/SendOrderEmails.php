<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminNewOrderMail;
use App\Mail\OrderReceiptMail;

class SendOrderEmails implements ShouldQueue
{
    public bool $afterCommit = true; // safe if orders are created in transactions

    public function handle(OrderPlaced $event): void
    {
        $order = $event->order->loadMissing(['orderDetails.product','user']); // ✅

        $billing = $order->billing ?? [];
        $customerEmail = $order->email
            ?? optional($order->user)->email
            ?? ($billing['email'] ?? null);

        Log::info('SendOrderEmails recipients', [
            'order_id'      => $order->id,
            'order_email'   => $order->email ?? null,
            'user_email'    => optional($order->user)->email,
            'billing_email' => $billing['email'] ?? null,
        ]);

        if ($customerEmail) {
            Mail::to($customerEmail)->send(new OrderReceiptMail($order));
        } else {
            Log::warning('No customer email for order', ['order_id' => $order->id]);
        }

        $adminEmail = env('ORDER_ADMIN_EMAIL');
        if ($adminEmail) {
            Mail::to($adminEmail)->send(new AdminNewOrderMail($order));
        } else {
            Log::warning('No admin email configured (ORDER_ADMIN_EMAIL not set)');
        }
    }
}
