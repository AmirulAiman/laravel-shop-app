<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@shopping-app.test',
            'role' => 'admin',
            'password' => Hash::make('admin123'), // password
        ]);
        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@shopping-app.test',
            'role' => 'customer',
            'password' => Hash::make('customer123'), // password
        ]);
        User::factory()->create([
            'name' => 'Test Shop Owner',
            'email' => 'shop.owner@shopping-app.test',
            'role' => 'shop_owner',
            'password' => Hash::make('owner123'), // password
        ]);
    }
}
