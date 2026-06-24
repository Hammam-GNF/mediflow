<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Icd10ImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('data/icd10_codes.csv');

        if (! file_exists($path)) {
            throw new \Exception(
                "ICD-10 file not found: {$path}"
            );
        }

        $handle = fopen($path, 'r');

        $batch = [];

        while (($row = fgetcsv($handle)) !== false) {

            if ($row[0] === 'CODE') continue;

            $batch[] = [
                'code' => trim($row[0]),
                'name' => trim($row[1]),
                'description' => $row[2] ?? null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= 1000) {
                DB::table('icd10_codes')->insert($batch);
                $batch = [];
            }
        }

        if (! empty($batch)) {

            DB::table('icd10_codes')
                ->insert($batch);
        }

        fclose($handle);
    }
}
