<?php

namespace App\Console\Commands;

use App\Models\Uploads;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ConvertToWebP extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert';

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

        // $imageFiles = File::files(public_path('uploads/categories'));

        // foreach ($imageFiles as $key => $imageFile) {

        //     $image = Image::make($imageFile->getPathname());
        //     $webpPath = 'uploads/categories/' . pathinfo($imageFile->getFilename(), PATHINFO_FILENAME) . '.webp';
        //     $image->encode('webp', 75)->save(public_path($webpPath));

        //     unlink(public_path('uploads/categories/'.$imageFile->getFilename()));

        //     $this->info('Running no. '.$key+1);
        // }

        // $uploads = Uploads::all();

        // foreach($uploads as $key => $upload){

        //     $extension = pathinfo($upload->file_name,PATHINFO_EXTENSION);
        //     $latestName = str_replace($extension,'webp',$upload->file_name);

        //     $upload->file_name = $latestName;
        //     $upload->extension = 'webp';
        //     $upload->save();

        // }
    }
}
