<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'user' => [
                    'name'     => 'Dr. Qazi Ikram',
                    'email'    => 'qaziikram@doctor.com',
                    'password' => Hash::make('password'),
                    'role'     => 'doctor',
                ],
                'doctor' => [
                    'license_number' => 'LIC-DOC-001',
                ],
                'specializations' => [1, 2], // Cardiology, Neurology
            ],
            [
                'user' => [
                    'name'     => 'Dr. Sajid Zali',
                    'email'    => 'sajid@example.com',
                    'password' => Hash::make('password'),
                    'role'     => 'doctor',
                ],
                'doctor' => [
                    'license_number' => 'LIC-DOC-002',
                ],
                'specializations' => [3, 4], // Orthopedics, Pediatrics
            ],
            [
                'user' => [
                    'name'     => 'Dr. Farman Aziz',
                    'email'    => 'farman@example.com',
                    'password' => Hash::make('password'),
                    'role'     => 'doctor',
                ],
                'doctor' => [
                    'license_number' => 'LIC-DOC-003',
                ],
                'specializations' => [5, 6], // Dermatology, General Practice
            ],
        ];

        foreach ($doctors as $data) {
            $user   = User::create($data['user']);
            $doctor = $user->doctor()->create($data['doctor']);
            $doctor->specializations()->sync($data['specializations']);
        }
    }
}