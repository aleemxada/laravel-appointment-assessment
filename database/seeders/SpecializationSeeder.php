<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    public function run(): void
    {
        $specializations = [
            ['name' => 'Cardiology',     'description' => 'Heart and cardiovascular system'],
            ['name' => 'Neurology',      'description' => 'Brain and nervous system'],
            ['name' => 'Orthopedics',    'description' => 'Bones, joints and muscles'],
            ['name' => 'Pediatrics',     'description' => 'Medical care for children'],
            ['name' => 'Dermatology',    'description' => 'Skin, hair and nails'],
            ['name' => 'General Practice', 'description' => 'General health and wellness'],
        ];

        foreach ($specializations as $specialization) {
            Specialization::create($specialization);
        }
    }
}