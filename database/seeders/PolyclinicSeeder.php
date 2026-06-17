<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Poli Umum',
            'Poli Gigi',
            'Poli Anak',
            'Poli Mata',
        ];

        foreach ($data as $name) {
            Polyclinic::firstOrCreate(
                ['name' => $name],
                [
                    'description' => null,
                    'is_active' => true,
                ]
            );
        }
    }

}
