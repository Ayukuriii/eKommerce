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
            [
                'category_id' => 3,
                'name' => 'Corsair Dominator TITANIUM RGB 32GB',
                'slug' => 'corsair-dominator-titanium-rgb-32gb',
                'description' => 'Powerful DDR5 RAM',
                'image' => 'images/hzwVNbVMF7B7amgjDGxyZLMGZOFYed9RsGg7Ykf0.png',
                'price' => 3350000,
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'ASUS Radeon RX 7900 XT TUF GAMING OC 20GB GDDR6 RDNA 3',
                'slug' => 'asus-radeon-rx-7900-xt-tuf-gaming-oc-20gb-gddr6-rdna-3',
                'description' => 'Super expensive vga card!',
                'image' => 'images/hzwVNbVMF7B7amgjDGxyZLMGZOFYed9RsGg7Ykf0.png',
                'price' => 17400000,
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category_id' => 4,
                'name' => 'Asrock Radeon RX 550 PHANTOM GAMING 4GB GDDR5',
                'slug' => 'asrock-radeon-rx-550-phantom-gaming-4gb-gddr5',
                'description' => 'Cheap as funny graphic card',
                'image' => 'images/hzwVNbVMF7B7amgjDGxyZLMGZOFYed9RsGg7Ykf0.png',
                'price' => 1210000,
                'quantity' => 41,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
