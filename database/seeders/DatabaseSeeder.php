<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Enums\UserRoleEnum;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Ekadian Haris',
            'username' => 'ayukuriii',
            'email' => 'ekadianharis@gmail.com',
            'phone_number' => '087763420873',
            'role' => UserRoleEnum::ADMIN->value,
            'password' => Hash::make('password'),
        ]);

        Category::insert([
            [
                'name' => 'Motherboard',
                'slug' => 'motherboard',
            ],
            [
                'name' => 'Processor',
                'slug' => 'processor',
            ],
            [
                'name' => 'Random Access Memory',
                'slug' => 'random-access-memory',
            ],
            [
                'name' => 'Graphic Card',
                'slug' => 'graphic-card',
            ],
        ]);

        Product::insert([
            [
                'category_id' => 1,
                'name' => 'Asrock B450M Steel Legend - AM4',
                'slug' => 'asrock-b450m-steel-legend-am4',
                'description' => 'Asrock motherboard for AM4',
                'image' => 'images/822rhYhJKDmm9m4W9N2vScQBI3wqsqJKAV5NEw75.png',
                'price' => 1350000,
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 2,
                'name' => 'AMD Ryzen 5 8500G AM5',
                'slug' => 'amd-ryzen5-8500g-am5',
                'description' => 'AM5 processor',
                'image' => 'images/hzwVNbVMF7B7amgjDGxyZLMGZOFYed9RsGg7Ykf0.png',
                'price' => 3100000,
                'quantity' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
