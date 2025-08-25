<?php

namespace App\Console\Commands;

use App\Models\CategoryMenu;
use App\Models\DisplaySection;
use App\Models\Settings;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class LinkChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All Links change by this command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting link changing..');

        $menus = CategoryMenu::latest()->get();
        foreach ($menus as $menu) {
            $menu->url = $this->changeUrl($menu->url);
            $menu->save();
        }

        $this->info('Menus url changed!');
        $this->info('Settings url changing...');

        $settings = Settings::whereNotIn('key',['fb_link','yt_link','insta_link','linkedin_link','pinterest_link'])->get();

        foreach ($settings as $setting) {
            if(filter_var($setting->value,FILTER_VALIDATE_URL)){
                $setting->value = $this->changeUrl($setting->value);
                $setting->save();
            }
            if(is_array(json_decode($setting->value))){
                $values = [];

                foreach (json_decode($setting->value) as $value) {
                    if(filter_var($value,FILTER_VALIDATE_URL)){
                        $values[] = $this->changeUrl($value);
                    }
                }
                // if(count($values) > 0){
                //     dd(json_encode(array_values($values)),json_encode($setting->value));
                // }
                if(count($values) > 0){
                    $setting->value = json_encode(array_values($values));
                    $setting->save();
                }
            }

        }
        $this->info('Settings url changed!');

        $sections = DisplaySection::all();
        foreach($sections as $section){
            $section->button_url = $this->changeUrl($section->button_url);
            $section->save();
        }
        Artisan::call('cache:clear');

    }

    protected function changeUrl($oldLink){

        $oldDomain = parse_url($oldLink,PHP_URL_HOST);
        $newDomain = parse_url(config('app.url'),PHP_URL_HOST);

        $link = str_replace($oldDomain,$newDomain,$oldLink);

        return $link;
    }
}
