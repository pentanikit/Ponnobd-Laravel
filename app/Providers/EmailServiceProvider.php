<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Mail\AdminNewOrderMail;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;

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
        // When a new order is created, email the admin
        Order::created(function (Order $order) {
            $admin = config('mail.admin_address');

            if (!empty($admin)) {
                Mail::to($admin)->queue(new AdminNewOrderMail($order));
                // Use ->send(...) if you don't have queues set up yet.
            }
        });
    }
}
