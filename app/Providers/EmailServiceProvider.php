<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\AdminNewOrderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
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
        Log::info('[OrderMailSP] boot()');

        Order::created(function (Order $order) {
            Log::info('[OrderMailSP] Order::created', ['order_id' => $order->id]);

            DB::afterCommit(function () use ($order) {
                Log::info('[OrderMailSP] afterCommit firing', ['order_id' => $order->id]);

                try {
                    // Use send() while debugging so queues don’t hide issues
                    Mail::queue(new AdminNewOrderMail($order));
                    Log::info('[OrderMailSP] Mail sent', ['order_id' => $order->id]);
                } catch (\Throwable $e) {
                    Log::error('[OrderMailSP] Mail error', ['order_id' => $order->id, 'msg' => $e->getMessage()]);
                }
            });
        });
    }
}
