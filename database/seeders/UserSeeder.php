<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        //Create other random users.
        $customers = User::factory(10)->create();
    }
}
