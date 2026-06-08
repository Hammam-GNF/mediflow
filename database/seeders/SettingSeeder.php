<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            ['key' => 'app_name'],
            ['value' => 'Laravel Template']
        );

        Setting::updateOrCreate(
            ['key' => 'app_email'],
            ['value' => 'admin@gmail.com']
        );

        Setting::updateOrCreate(
            ['key' => 'app_phone'],
            ['value' => '081234567890']
        );
    }
}
