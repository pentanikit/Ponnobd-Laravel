<?php

use Livewire\Livewire;
use App\Livewire\AboutUs;
use App\Livewire\ContactUs;
use App\Livewire\Frontend\Blog;
use App\Livewire\Frontend\BlogDetails;
use App\Livewire\Frontend\Cart;
use App\Livewire\Frontend\Checkout;
use App\Livewire\Frontend\Customer\Dashboard;
use App\Livewire\Frontend\Customer\MyProfile;
use App\Livewire\Frontend\Customer\OrderDetails;
use App\Livewire\Frontend\Customer\Orders;
use App\Livewire\Frontend\Index;
use App\Livewire\Frontend\Shop;
use App\Livewire\Frontend\Wishlist;
use App\Livewire\OrderSuccess;
use App\Livewire\Page;
use App\Livewire\ProductOrCategory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/', Index::class)->name('home');
Route::get('/blog', Blog::class)->name('blog');
Route::get('/blog/{slug}', BlogDetails::class)->name('blog.details');
Route::get('page/{slug}', Page::class)->name('page');
Route::get('about-us', AboutUs::class)->name('about.us');
Route::get('contact-us', ContactUs::class)->name('contact.us');
Route::get('wishlists', Wishlist::class)->name('wishlist');
Route::get('shop', Shop::class)->name('shop');
Route::get('cart', Cart::class)->name('cart');
Route::get('checkout', Checkout::class)->name('checkout');
Route::get('order/success/{order_id}', OrderSuccess::class)->name('order.success');

Route::middleware('auth')->prefix('customer')->name('customer.')->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('profile', MyProfile::class)->name('profile');
    Route::get('orders', Orders::class)->name('orders');
    Route::get('order/details/{id}', OrderDetails::class)->name('order.details');
});

Route::prefix('uploader')->name('uploader.')->group(function () {
    Route::post('/', [App\Http\Controllers\UploaderController::class, 'show_uploader']);
    Route::post('upload', [App\Http\Controllers\UploaderController::class, 'upload']);
    Route::get('get_uploaded_files', [App\Http\Controllers\UploaderController::class, 'get_uploaded_files'])->name('get.uploaded.files');
    Route::post('get_file_by_ids', [App\Http\Controllers\UploaderController::class, 'get_preview_files'])->name('get.preview.files');
    Route::get('download/{id}', [App\Http\Controllers\UploaderController::class, 'attachment_download'])->name('download.attachment');
});

// Social Login
Route::get('auth/{provider}/callback', [App\Http\Controllers\Auth\SocialLoginController::class, 'providerCallback']);
Route::get('auth/{provider}', [App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social.redirect');

// Ui Routes
Auth::routes();

// Product details
Route::get('/{slug}', ProductOrCategory::class)->name('product.details');




Route::get("nullable",function(){

 App\Models\Product::each(function($product){ 

$product->attributes = null;
$product->save();
   
return "Success!";
});

});

