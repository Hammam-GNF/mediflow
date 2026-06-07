<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            AdminSeeder::class,
        ]);

        User::factory()
            ->count(3)
            ->create()
            ->each(function ($user) {
                $user->assignRole('admin');
            });

        User::factory()
            ->count(50)
            ->create()
            ->each(function ($user) {
                $user->assignRole('user');
            });
    }
}
