<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Enums\UserRoleEnum;
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
            'password' => Hash::make('qwe12334'),
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
    }
}
