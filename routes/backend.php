<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/profile', [DashboardController::class,'profile'])->name('profile');
Route::post('/profile/update', [DashboardController::class,'profileUpdate'])->name('profile.update');
Route::get('/cache-clear', [DashboardController::class, 'cacheClear'])->name('cache.clear');
Route::get('/update-url', [DashboardController::class, 'updateUrl'])->name('update.url');

// Category
Route::prefix('categories')->name('categories.')->middleware('can:categories_view')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\CategoryController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\CategoryController::class, 'create'])->middleware('can:categories_add')->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\CategoryController::class, 'store'])->middleware('can:categories_add')->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\Backend\CategoryController::class, 'edit'])->middleware('can:categories_edit')->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\CategoryController::class, 'update'])->middleware('can:categories_edit')->name('update');
    Route::get('/destroy/{id}', [App\Http\Controllers\Backend\CategoryController::class, 'destroy'])->middleware('can:categories_delete')->name('destroy');
    Route::post('featured', [App\Http\Controllers\Backend\CategoryController::class, 'updateFeatured'])->name('featured');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\CategoryController::class, 'bulkDelete'])->middleware('can:categories_bulk_delete')->name('bulk.delete');
});

// Blog Categories
Route::prefix('blog/categories')->name('blog.categories.')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'update'])->name('update');
    Route::get('/destroy/{id}', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'destroy'])->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\Blog\CategoryController::class, 'bulkDelete'])->name('bulk.delete');
});

// Posts
Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\Blog\PostController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\Blog\PostController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\Blog\PostController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\Backend\Blog\PostController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\Blog\PostController::class, 'update'])->name('update');
    Route::get('/destroy/{id}', [App\Http\Controllers\Backend\Blog\PostController::class, 'destroy'])->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\Blog\PostController::class, 'bulkDelete'])->name('bulk.delete');
});

// Brand
Route::prefix('brand')->name('brand.')->middleware('can:brands_view')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\BrandController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\BrandController::class, 'create'])->middleware('can:brands_add')->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\BrandController::class, 'store'])->middleware('can:brands_add')->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\Backend\BrandController::class, 'edit'])->middleware('can:brands_edit')->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\BrandController::class, 'update'])->middleware('can:brands_edit')->name('update');
    Route::get('/destroy/{id}', [App\Http\Controllers\Backend\BrandController::class, 'destroy'])->middleware('can:brands_delete')->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\BrandController::class, 'bulkDelete'])->middleware('can:brands_bulk_delete')->name('bulk.delete');

});

// Products
Route::prefix('products')->name('products.')->middleware('can:products_view')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\ProductController::class, 'index'])->name('index');
    Route::post('/get', [App\Http\Controllers\Backend\ProductController::class, 'get'])->name('get');
    Route::get('/create', [App\Http\Controllers\Backend\ProductController::class, 'create'])->middleware('can:products_add')->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\ProductController::class, 'store'])->middleware('can:products_add')->name('store');
    Route::get('/edit/{id}', [App\Http\Controllers\Backend\ProductController::class, 'edit'])->middleware('can:products_edit')->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\ProductController::class, 'update'])->middleware('can:products_edit')->name('update');
    Route::get('/destroy/{id}', [App\Http\Controllers\Backend\ProductController::class, 'destroy'])->middleware('can:products_delete')->name('destroy');
    Route::post('todays_deal', [App\Http\Controllers\Backend\ProductController::class, 'updateTodaysDeal'])->name('todays_deal');
    Route::post('featured', [App\Http\Controllers\Backend\ProductController::class, 'updateFeatured'])->name('featured');
    Route::post('published', [App\Http\Controllers\Backend\ProductController::class, 'updatePublished'])->middleware('can:products_publish')->name('published');
    Route::post('add-choice-option', [App\Http\Controllers\Backend\ProductController::class, 'addChoiceOption'])->name('add.choice.option');
    Route::post('sku-combination', [App\Http\Controllers\Backend\ProductController::class, 'skuCombination'])->name('sku.combination');
    Route::post('edit-sku-combination', [App\Http\Controllers\Backend\ProductController::class, 'editSkuCombination'])->name('edit.sku.combination');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\ProductController::class, 'bulkDelete'])->middleware('can:products_bulk_delete')->name('bulk.delete');
});

// Attribute
Route::prefix('attributes')->name('attribute.')->middleware('can:attributes_view')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\AttributeController::class, 'index'])->name('index');
    Route::get('show/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'show'])->middleware('can:attribute_value_view')->name('show');
    Route::get('edit/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'edit'])->middleware('can:attributes_edit')->name('edit');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'destroy'])->middleware('can:attributes_delete')->name('destroy');
    Route::post('store', [App\Http\Controllers\Backend\AttributeController::class, 'store'])->middleware('can:attributes_add')->name('store');
    Route::post('update/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'update'])->middleware('can:attributes_edit')->name('update');
    Route::post('value/store', [App\Http\Controllers\Backend\AttributeController::class, 'valueStore'])->middleware('can:attribute_value_add')->name('value.store');
    Route::get('value/delete/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'valueDelete'])->middleware('can:attribute_value_delete')->name('value.delete');
    Route::get('value/edit/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'valueEdit'])->middleware('can:attribute_value_edit')->name('value.edit');
    Route::post('value/update/{id}', [App\Http\Controllers\Backend\AttributeController::class, 'valueUpdate'])->middleware('can:attribute_value_edit')->name('value.update');
});
// Order
Route::prefix('order')->name('order.')->middleware('can:orders_view')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\OrderController::class, 'index'])->name('index');
    Route::get('show/{id}', [App\Http\Controllers\Backend\OrderController::class, 'show'])->name('show');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\OrderController::class, 'destroy'])->middleware('can:orders_delete')->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\OrderController::class, 'bulkDelete'])->middleware('can:orders_bulk_delete')->name('bulk.delete');
    Route::post('update-status', [App\Http\Controllers\Backend\OrderController::class, 'updateStatus'])->middleware('can:orders_delivery_status_change')->name('update.status');
    Route::post('update-payment-status', [App\Http\Controllers\Backend\OrderController::class, 'updatePaymentStatus'])->middleware('can:orders_payment_status_change')->name('update.payment.status');
});
// Customers
Route::prefix('customers')->name('customers.')->middleware('can:customers_view')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\CustomerController::class, 'index'])->name('index');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\CustomerController::class, 'bulkDelete'])->middleware('can:customers_bulk_delete')->name('bulk.delete');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\CustomerController::class, 'destroy'])->middleware('can:customers_delete')->name('destroy');
});

// Staff
Route::prefix('staff')->name('staff.')->middleware('role:admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\StaffController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\StaffController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\StaffController::class, 'store'])->name('store');
    Route::get('edit/{id}', [App\Http\Controllers\Backend\StaffController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\StaffController::class, 'update'])->name('update');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\StaffController::class, 'destroy'])->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\StaffController::class, 'bulkDelete'])->name('bulk.delete');
});

// Roles & Permissions
Route::prefix('roles')->name('roles.')->middleware('role:admin')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\RolePermissionController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\RolePermissionController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\RolePermissionController::class, 'store'])->name('store');
    Route::get('edit/{id}', [App\Http\Controllers\Backend\RolePermissionController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\RolePermissionController::class, 'update'])->name('update');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\RolePermissionController::class, 'destroy'])->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\RolePermissionController::class, 'bulkDelete'])->name('bulk.delete');
});

// Pages
Route::prefix('pages')->name('pages.')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\PageController::class, 'index'])->middleware('can:page_view')->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\PageController::class, 'create'])->middleware('can:page_add')->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\PageController::class, 'store'])->middleware('can:page_add')->name('store');
    Route::get('edit/{id}', [App\Http\Controllers\Backend\PageController::class, 'edit'])->middleware('can:page_edit')->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\PageController::class, 'update'])->middleware('can:page_edit')->name('update');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\PageController::class, 'destroy'])->middleware('can:page_delete')->name('destroy');
    // Home
    Route::get('home', [App\Http\Controllers\Backend\PageController::class, 'home'])->middleware('can:home_page')->name('home');
    // About Us
    Route::get('/about-us', [App\Http\Controllers\Backend\PageController::class, 'aboutUs'])->middleware('can:about_us_page')->name('about.us');
    // Contact Us
    Route::get('/contact-us', [App\Http\Controllers\Backend\PageController::class, 'contactUs'])->middleware('can:contact_us_page')->name('contact.us');
});

// Settings
Route::prefix('settings')->name('settings.')->group(function () {
    // Footer
    Route::get('footer', [App\Http\Controllers\Backend\PageController::class, 'footer'])->middleware('can:footer_settings')->name('footer');
    // System
    Route::get('system', [App\Http\Controllers\Backend\PageController::class, 'system'])->middleware('can:system_settings')->name('system');
    // Header
    Route::get('header', [App\Http\Controllers\Backend\PageController::class, 'header'])->middleware('can:header_settings')->name('header');
    // Settings update
    Route::post('update', [App\Http\Controllers\Backend\SettingsController::class, 'update'])->name('update');
    // Home Section
    Route::prefix('home-section')->name('home.section.')->middleware('can:display_section_settings')->group(function () {
        Route::get('/', [App\Http\Controllers\Backend\HomeSectionController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Backend\HomeSectionController::class, 'create'])->name('create');
        Route::post('/store', [App\Http\Controllers\Backend\HomeSectionController::class, 'store'])->name('store');
        Route::get('edit/{id}', [App\Http\Controllers\Backend\HomeSectionController::class, 'edit'])->name('edit');
        Route::post('update/{id}', [App\Http\Controllers\Backend\HomeSectionController::class, 'update'])->name('update');
        Route::get('destroy/{id}', [App\Http\Controllers\Backend\HomeSectionController::class, 'destroy'])->name('destroy');
    });
});

// Categories Menu
Route::prefix('categories-menus')->name('categories.menus.')->middleware('can:category_menus')->group(function () {
    Route::get('/', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'store'])->name('store');
    Route::get('edit/{id}', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'edit'])->name('edit');
    Route::post('update/{id}', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'update'])->name('update');
    Route::get('destroy/{id}', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'destroy'])->name('destroy');
    Route::delete('bulk/delete', [App\Http\Controllers\Backend\CategoriesMenuController::class, 'bulkDelete'])->name('bulk.delete');
});
