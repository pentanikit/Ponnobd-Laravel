<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ChangeToJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:json';

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
        // $categories = Category::with('products')->get();
        // $count = 0;
        // foreach($categories as $ca){
        //     if(count($ca->products) == 0){
        //         $ca->delete();
        //         $count++;
        //     }
        // }

        // $this->info('Total '.$count);
    }
}
