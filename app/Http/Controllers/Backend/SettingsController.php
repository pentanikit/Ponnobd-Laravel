<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            if ($type == 'site_name') {
                Artisan::call('config:cache');
                $this->overWriteEnv('APP_NAME', $request[$type]);
            } else {
                $settings = Settings::where('key', $type)->first();

                if ($settings != null) {
                    if (gettype($request[$type]) == 'array') {
                        $settings->value = json_encode($request[$type]);
                    } else {
                        $settings->value = $request[$type];
                    }
                    $settings->save();
                } else {
                    $settings = new Settings();
                    $settings->key = $type;

                    if (gettype($request[$type]) == 'array') {
                        $settings->value = json_encode($request[$type]);
                    } else {
                        $settings->value = $request[$type];
                    }
                    $settings->save();
                }
            }
        }
        
        Artisan::call('view:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * overWrite the Env File values.
     * @param  String type
     * @param  String value
     * @return \Illuminate\Http\Response
     */
    public function overWriteEnv($type, $val)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"'.trim($val).'"';
            if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                file_put_contents($path, str_replace(
                    $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                ));
            }
            else{
                file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
            }
        }
    }
}
