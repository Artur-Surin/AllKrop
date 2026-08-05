<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@kropyvnytskyi.city'],
            [
                'name' => 'Адміністратор',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@kropyvnytskyi.city'],
            [
                'name' => 'Тестовий Користувач',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $this->call(ContentSeeder::class);
    }
}
