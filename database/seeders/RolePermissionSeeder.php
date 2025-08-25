<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role::create(['name' => 'admin','guard_name' => 'web']);
        // Permission::insert([
        //     // Categories
        //     ['name' => 'categories_view','guard_name' => 'web'],
        //     ['name' => 'categories_add','guard_name' => 'web'],
        //     ['name' => 'categories_edit','guard_name' => 'web'],
        //     ['name' => 'categories_delete','guard_name' => 'web'],
        //     ['name' => 'categories_bulk_delete','guard_name' => 'web'],
        //     // Brands
        //     ['name' => 'brands_view','guard_name' => 'web'],
        //     ['name' => 'brands_add','guard_name' => 'web'],
        //     ['name' => 'brands_edit','guard_name' => 'web'],
        //     ['name' => 'brands_delete','guard_name' => 'web'],
        //     ['name' => 'brands_bulk_delete','guard_name' => 'web'],
        //     // Products
        //     ['name' => 'products_view','guard_name' => 'web'],
        //     ['name' => 'products_add','guard_name' => 'web'],
        //     ['name' => 'products_edit','guard_name' => 'web'],
        //     ['name' => 'products_delete','guard_name' => 'web'],
        //     ['name' => 'products_bulk_delete','guard_name' => 'web'],
        //     ['name' => 'products_publish','guard_name' => 'web'],
        //     // Attributes
        //     ['name' => 'attributes_view','guard_name' => 'web'],
        //     ['name' => 'attributes_add','guard_name' => 'web'],
        //     ['name' => 'attributes_edit','guard_name' => 'web'],
        //     ['name' => 'attributes_delete','guard_name' => 'web'],
        //     // Attribute Value
        //     ['name' => 'attribute_value_view','guard_name' => 'web'],
        //     ['name' => 'attribute_value_add','guard_name' => 'web'],
        //     ['name' => 'attribute_value_edit','guard_name' => 'web'],
        //     ['name' => 'attribute_value_delete','guard_name' => 'web'],
        //     // Orders
        //     ['name' => 'orders_view','guard_name' => 'web'],
        //     ['name' => 'orders_payment_status_change','guard_name' => 'web'],
        //     ['name' => 'orders_delivery_status_change','guard_name' => 'web'],
        //     ['name' => 'orders_delete','guard_name' => 'web'],
        //     ['name' => 'orders_bulk_delete','guard_name' => 'web'],
        //     // Customers
        //     ['name' => 'customers_view','guard_name' => 'web'],
        //     ['name' => 'customers_delete','guard_name' => 'web'],
        //     ['name' => 'customers_bulk_delete','guard_name' => 'web'],
        //     // Pages
        //     ['name' => 'page_view','guard_name' => 'web'],
        //     ['name' => 'page_add','guard_name' => 'web'],
        //     ['name' => 'page_edit','guard_name' => 'web'],
        //     ['name' => 'page_delete','guard_name' => 'web'],

        //     // Others Page
        //     ['name' => 'home_page','guard_name' => 'web'],
        //     ['name' => 'about_us_page','guard_name' => 'web'],
        //     ['name' => 'contact_us_page','guard_name' => 'web'],
        //     // Settings
        //     ['name' => 'category_menus','guard_name' => 'web'],
        //     ['name' => 'system_settings','guard_name' => 'web'],
        //     ['name' => 'header_settings','guard_name' => 'web'],
        //     ['name' => 'display_section_settings','guard_name' => 'web'],
        //     ['name' => 'footer_settings','guard_name' => 'web'],
        // ]);

        // $role = Role::where('name','admin')->first();
        // $role->syncPermissions(Permission::all());
        // $main_admin = User::where('username','raquibul')->first();
        // $main_admin->assignRole('admin');

    }
}
