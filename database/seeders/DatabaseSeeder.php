<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::create([
        //     'username' => 'raquibul',
        //     'user_type' => 'admin',
        //     'name' => 'Ponnobd Electronics',
        //     'email' => 'raquibul2030@gmail.com',
        //     'password' => bcrypt('ponnobd')
        // ]);

        // $this->call(ImportColors::class);
        // $this->call(CountrySeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
