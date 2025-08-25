<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Importer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $products = Http::withOptions([
            'verify' => false
        ])->get('https://backup.ponnobd.com/wp-json/wc/v3/products', [
            'consumer_key' => 'ck_a3a6859040b0d41ce2cc0c922a17679caf1b33cd',
            'consumer_secret' => 'cs_435776f8c7bae81d6becd0dc42da83e0dbbd17e5',
            'per_page' => 100,
            'page' => 1,
            'status' => 'publish',
            'type' => 'simple'
        ])->json();

         dd($products);

    }
}
