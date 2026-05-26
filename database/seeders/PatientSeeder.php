<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $patients = [
            ['name' => 'Alice Johnson',  'email' => 'patient1@example.com',  'dob' => '1990-05-14'],
            ['name' => 'Bob Martinez',   'email' => 'patient2@example.com',  'dob' => '1985-08-22'],
            ['name' => 'Carol White',    'email' => 'patient3@example.com',  'dob' => '1992-11-03'],
            ['name' => 'David Brown',    'email' => 'patient4@example.com',  'dob' => '1978-02-17'],
            ['name' => 'Emma Davis',     'email' => 'patient5@example.com',  'dob' => '1995-07-30'],
            ['name' => 'Frank Miller',   'email' => 'patient6@example.com',  'dob' => '1988-04-09'],
            ['name' => 'Grace Wilson',   'email' => 'patient7@example.com',  'dob' => '2000-12-25'],
            ['name' => 'Henry Taylor',   'email' => 'patient8@example.com',  'dob' => '1975-09-18'],
            ['name' => 'Isabella Moore', 'email' => 'patient9@example.com',  'dob' => '1998-03-07'],
            ['name' => 'Jack Anderson',  'email' => 'patient10@example.com', 'dob' => '1983-06-21'],
        ];

        foreach ($patients as $data) {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make('password'),
                'role'     => 'patient',
            ]);

            $user->patient()->create([
                'date_of_birth' => $data['dob'],
            ]);
        }
    }
}