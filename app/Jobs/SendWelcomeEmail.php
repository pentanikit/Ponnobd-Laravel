<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    // optional: control retry behavior
    public int $tries = 3;               // retry up to 3 times
    public int $backoff = 30;            // wait 30s between retries
    // public $timeout = 120;            // seconds before job times out
    public function __construct(public string $email, public string $name)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         Mail::to($this->email)->send(new WelcomeMail($this->name));
    }
}
