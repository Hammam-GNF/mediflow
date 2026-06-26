<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Polyclinic;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::role('doctor')->get();

        foreach ($users as $index => $user) {

            Doctor::firstOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'polyclinic_id' => Polyclinic::inRandomOrder()->first()->id,
                    'doctor_code' => 'DOC-'.str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'nik' => fake()->numerify('################'),
                    'phone' => fake()->phoneNumber(),
                    'is_active' => true,
                ]
            );
        }
    }
}
