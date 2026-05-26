<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $doctors  = Doctor::all();
        $patients = Patient::all();

        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        $appointments = [
            // Past appointments (completed/cancelled)
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[0]->id,
                'scheduled_at' => now()->subDays(10)->setTime(9, 0),
                'status'       => 'completed',
                'notes'        => 'Routine checkup, all clear.',
            ],
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[1]->id,
                'scheduled_at' => now()->subDays(8)->setTime(10, 0),
                'status'       => 'completed',
                'notes'        => 'Follow-up on blood pressure.',
            ],
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[2]->id,
                'scheduled_at' => now()->subDays(7)->setTime(11, 0),
                'status'       => 'cancelled',
                'notes'        => 'Patient cancelled due to travel.',
            ],
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[3]->id,
                'scheduled_at' => now()->subDays(5)->setTime(14, 0),
                'status'       => 'completed',
                'notes'        => 'Knee pain assessment.',
            ],
            [
                'doctor_id'    => $doctors[2]->id,
                'patient_id'   => $patients[4]->id,
                'scheduled_at' => now()->subDays(4)->setTime(9, 30),
                'status'       => 'completed',
                'notes'        => 'Skin rash consultation.',
            ],
            [
                'doctor_id'    => $doctors[2]->id,
                'patient_id'   => $patients[5]->id,
                'scheduled_at' => now()->subDays(3)->setTime(15, 0),
                'status'       => 'cancelled',
                'notes'        => null,
            ],
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[6]->id,
                'scheduled_at' => now()->subDays(2)->setTime(10, 30),
                'status'       => 'completed',
                'notes'        => 'ECG results reviewed.',
            ],

            // Today / very soon
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[7]->id,
                'scheduled_at' => now()->addHours(2),
                'status'       => 'confirmed',
                'notes'        => 'Sports injury follow-up.',
            ],
            [
                'doctor_id'    => $doctors[2]->id,
                'patient_id'   => $patients[8]->id,
                'scheduled_at' => now()->addHours(4),
                'status'       => 'pending',
                'notes'        => null,
            ],

            // Upcoming appointments
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[9]->id,
                'scheduled_at' => now()->addDays(1)->setTime(9, 0),
                'status'       => 'confirmed',
                'notes'        => 'Annual heart checkup.',
            ],
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[0]->id,
                'scheduled_at' => now()->addDays(2)->setTime(10, 0),
                'status'       => 'pending',
                'notes'        => null,
            ],
            [
                'doctor_id'    => $doctors[2]->id,
                'patient_id'   => $patients[1]->id,
                'scheduled_at' => now()->addDays(2)->setTime(14, 30),
                'status'       => 'confirmed',
                'notes'        => 'General wellness check.',
            ],
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[2]->id,
                'scheduled_at' => now()->addDays(3)->setTime(11, 0),
                'status'       => 'pending',
                'notes'        => 'Chest pain evaluation.',
            ],
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[3]->id,
                'scheduled_at' => now()->addDays(4)->setTime(9, 30),
                'status'       => 'confirmed',
                'notes'        => 'Post-surgery checkup.',
            ],
            [
                'doctor_id'    => $doctors[2]->id,
                'patient_id'   => $patients[4]->id,
                'scheduled_at' => now()->addDays(5)->setTime(15, 0),
                'status'       => 'pending',
                'notes'        => null,
            ],
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[5]->id,
                'scheduled_at' => now()->addDays(6)->setTime(10, 0),
                'status'       => 'confirmed',
                'notes'        => 'Neurology referral follow-up.',
            ],
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[6]->id,
                'scheduled_at' => now()->addDays(7)->setTime(13, 0),
                'status'       => 'pending',
                'notes'        => null,
            ],
            [
                'doctor_id'    => $doctors[2]->id,
                'patient_id'   => $patients[7]->id,
                'scheduled_at' => now()->addDays(8)->setTime(11, 30),
                'status'       => 'confirmed',
                'notes'        => 'Eczema treatment review.',
            ],
            [
                'doctor_id'    => $doctors[0]->id,
                'patient_id'   => $patients[8]->id,
                'scheduled_at' => now()->addDays(10)->setTime(9, 0),
                'status'       => 'pending',
                'notes'        => null,
            ],
            [
                'doctor_id'    => $doctors[1]->id,
                'patient_id'   => $patients[9]->id,
                'scheduled_at' => now()->addDays(12)->setTime(14, 0),
                'status'       => 'confirmed',
                'notes'        => 'Pediatric growth assessment.',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}