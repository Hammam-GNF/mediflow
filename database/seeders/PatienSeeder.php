<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {

            Patient::create([
                'medical_record_number' => 'MRN-' . str_pad($i, 6, '0', STR_PAD_LEFT),

                'name' => fake()->name(),

                'nik' => fake()->numerify('################'),

                'gender' => fake()->randomElement([
                    'male',
                    'female',
                ]),

                'birth_date' => fake()->dateTimeBetween(
                    '-70 years',
                    '-1 years'
                ),

                'phone' => fake()->phoneNumber(),

                'address' => fake()->address(),

                'is_active' => fake()->boolean(90),
            ]);
        }
    }
}
