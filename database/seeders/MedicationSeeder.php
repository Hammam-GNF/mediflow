<?php

namespace Database\Seeders;

use App\Models\Medication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Medication::create([
            'code' => 'MED' . str_pad(1, 6, '0', STR_PAD_LEFT),
            'name' => 'Paracetamol 500mg',
            'unit' => 'Tablet',
            'price' => 1000,
        ]);

        Medication::create([
            'code' => 'MED' . str_pad(2, 6, '0', STR_PAD_LEFT),
            'name' => 'Aspirin 325mg',
            'unit' => 'Tablet',
            'price' => 2000,
        ]);
    }
}
