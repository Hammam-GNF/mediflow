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
            ['key' => 'app_description'],
            ['value' => 'A Laravel template with admin panel, activity log, and settings management.']
        );

        Setting::updateOrCreate(
            ['key' => 'company_email'],
            ['value' => 'admin@gmail.com']
        );

        Setting::updateOrCreate(
            ['key' => 'company_phone'],
            ['value' => '081234567890']
        );

        Setting::updateOrCreate(
            ['key' => 'company_address'],
            ['value' => 'Indonesia']
        );

        Setting::updateOrCreate(
            ['key' => 'pagination_per_page'],
            ['value' => '10']
        );

        Setting::updateOrCreate(
            ['key' => 'registration_enabled'],
            ['value' => '1']
        );

        Setting::updateOrCreate(
            ['key' => 'satusehat_environment'],
            ['value' => 'sandbox']
        );

        Setting::updateOrCreate(
            ['key' => 'satusehat_organization_id'],
            ['value' => '']
        );

        Setting::updateOrCreate(
            ['key' => 'satusehat_client_key'],
            ['value' => '']
        );

        Setting::updateOrCreate(
            ['key' => 'satusehat_client_secret'],
            ['value' => '']
        );
    }
}
