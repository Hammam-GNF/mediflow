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
        $items = [
            [
                'name' => 'Paracetamol 500mg',
                'unit' => 'Tablet',
                'price' => 1000,
                'stock' => 100,
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'unit' => 'Capsule',
                'price' => 2000,
                'stock' => 50,
            ],
            [
                'name' => 'Vitamin C 500mg',
                'unit' => 'Tablet',
                'price' => 1500,
                'stock' => 75,
            ],
        ];

        foreach ($items as $index => $item) {

            $medication = Medication::create([
                'code' => 'MED' . str_pad(
                    $index + 1,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),

                'name' => $item['name'],
                'unit' => $item['unit'],
                'price' => $item['price'],
            ]);

            $medication->stock()->create([
                'current_stock' => $item['stock'],
            ]);

            $medication->stockMovements()->create([
                'type' => 'in',
                'quantity' => $item['stock'],
                'notes' => 'Initial stock',
                'user_id' => null,
            ]);
        }
        
    }
}
