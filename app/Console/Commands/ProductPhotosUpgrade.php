<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class ProductPhotosUpgrade extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:product-photos-upgrade';

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
        $products = Product::all();

        foreach ($products as $product) {

            $photos = is_array($product->photos) ? json_encode($product->photos) : $product->photos;
            $product->photos = $photos;
            $product->save();

            $this->info($product->id);
        }
    }
}
