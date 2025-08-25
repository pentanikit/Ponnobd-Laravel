<?php

use App\Models\Settings;
use App\Models\Uploads;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

if (! function_exists('uploadedFile')) {
    function uploadedFile($id, $withoutUploads = true)
    {
        return $withoutUploads ? Cache::rememberForever('upload-'.$id, function () use ($id) {
            return asset(Uploads::find($id)?->file_name);
        }) : asset($id);

    }
}

if (! function_exists('price')) {
    function price($price)
    {
        $price = number_format($price, 2);

        return '৳ '.$price;
    }
}
if (! function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return '৳'.$price;
    }
}
if (! function_exists('guestID')) {
    function guestID()
    {
        if (auth()->check()) {
            return Session::forget('guest_id');
        } elseif (! auth()->check() && ! Session::has('guest_id')) {
            return Session::put('guest_id', uniqid());
        }

        return Session::get('guest_id');
    }
}
if (! function_exists('profilePic')) {
    function profilePic()
    {
        return uploadedFile(auth()->user()->profile_pic, false);
    }
}
if (! function_exists('user')) {
    function user($column)
    {
        return auth()->user()->{$column};
    }
}
if (! function_exists('settings')) {
    function settings($key)
    {
        $settings = Cache::rememberForever('setting-'.$key, function () use ($key) {
            return Settings::where('key', $key)->first()->value ?? '';
        });

        return $settings;
    }
}
