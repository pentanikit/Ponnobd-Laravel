<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\Uploads;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FileTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:file-transfer';

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

        $this->info('Starting file transferring...');
        $type = [
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'svg' => 'image',
            'webp' => 'image',
            'gif' => 'image',
            'mp4' => 'video',
            'mpg' => 'video',
            'mpeg' => 'video',
            'webm' => 'video',
            'ogg' => 'video',
            'avi' => 'video',
            'mov' => 'video',
            'flv' => 'video',
            'swf' => 'video',
            'mkv' => 'video',
            'wmv' => 'video',
            'wma' => 'audio',
            'aac' => 'audio',
            'wav' => 'audio',
            'mp3' => 'audio',
            'zip' => 'archive',
            'rar' => 'archive',
            '7z' => 'archive',
            'doc' => 'document',
            'txt' => 'document',
            'docx' => 'document',
            'pdf' => 'document',
            'csv' => 'document',
            'xml' => 'document',
            'ods' => 'document',
            'xlr' => 'document',
            'xls' => 'document',
            'xlsx' => 'document',
        ];

        // foreach (Category::where('status','no')->get() as $key => $category) {

        //     if ($category->icon != null && file_exists(storage_path('app/'.$category->icom))) {
        //         $arr = explode('.', $category->icon);
        //         if(isset($arr[1])){
        //             $upload = Uploads::create([
        //                 'file_original_name' => $category->icon, 'file_name' => $category->icon, 'user_id' => User::where('user_type', 'admin')->first()->id, 'extension' => $arr[1],
        //                 'type' => isset($arr[1]) ?  $type[$arr[1]] : "others", 'file_size' => filesize(storage_path('app/'.$category->icon))
        //             ]);
        //             $category->status = 'yes';
        //             $category->icon = $upload->id;
        //             $category->save();
        //         }
        //     }
        // }

        $this->info('Category transferred done.');
        // $this->info('Product transferring...');

        // foreach (Product::where('success','yes')->get() as $key => $product) {

        //     try {
        //         DB::beginTransaction();

        //         if ($product->photos != null) {
        //             $files = array();
        //             foreach (explode(',',$product->photos) as $key => $photo) {
        //                 $arr = explode('.', $photo);

        //                 array_push($files, [
        //                     'id' => $photo
        //                 ]);
        //             }

        //             $product->photos = json_encode($files);
        //             $product->success = 'yes';
        //             $product->save();
        //         }
        //         // if ($product->thumbnail_img != null && file_exists(storage_path('app/'.$product->thumbnail_img))) {
        //         //     $arr = explode('.', $product->thumbnail_img);

        //         //     $upload = Uploads::create([
        //         //         'file_original_name' => $product->thumbnail_img, 'file_name' => $product->thumbnail_img, 'user_id' => $product->user_id, 'extension' => $arr[1],
        //         //         'type' => isset($type[$arr[1]]) ?  $type[$arr[1]] : "others", 'file_size' => filesize(storage_path('app/'.$product->thumbnail_img)) ?? '0'
        //         //     ]);

        //         //     $product->thumbnail_img = $upload->id;
        //         //     $product->success = 'yes';
        //         //     $product->save();
        //         // }

        //         DB::commit();

        //     } catch (\Throwable $th) {
        //         DB::rollBack();
        //         throw $th;
        //     }
        // }

        // File Name Changes
        $this->info('Hureeeh, Tranfer completed.');

    }
}
