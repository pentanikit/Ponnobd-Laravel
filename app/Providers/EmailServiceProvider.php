<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\AdminNewOrderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Log::info('[OrderMailSP] boot() called'); // 1) Provider actually loaded?

        // Fire AFTER DB transaction commits (prevents silent rollbacks swallowing the event)
        Order::created(function (Order $order) {
            Log::info('[OrderMailSP] Order::created fired', ['order_id' => $order->id]);

            $admin = config('mail.admin_address');
            Log::info('[OrderMailSP] admin email from config', ['admin' => $admin]);

            if ($admin) {
                // Use send() for debugging. Queues can hide issues if no worker is running.
                try {
                    Mail::to($admin)->send(new AdminOrderPlaced($order));
                    Log::info('[OrderMailSP] Mail::send dispatched', ['order_id' => $order->id]);
                } catch (\Throwable $e) {
                    Log::error('[OrderMailSP] Mail failed', ['error' => $e->getMessage()]);
                }
            } else {
                Log::warning('[OrderMailSP] admin email is empty');
            }
        })->afterCommit(); // <— important if you create orders inside DB::transaction()

        // Optional: also listen to saved for extra signal while debugging
        Order::saved(function (Order $order) {
            Log::info('[OrderMailSP] Order::saved fired', ['order_id' => $order->id]);
        });
    }
}
