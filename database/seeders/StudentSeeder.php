<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Sample student accounts for testing
        $students = [
            ['name' => 'John Ssemwogerere',  'email' => 'john.s@mengo.sc.ug'],
            ['name' => 'Aisha Nakamya',       'email' => 'aisha.n@mengo.sc.ug'],
            ['name' => 'David Mugisha',        'email' => 'david.m@mengo.sc.ug'],
        ];

        foreach ($students as $student) {
            User::firstOrCreate(
                ['email' => $student['email']],
                [
                    'name'     => $student['name'],
                    'password' => Hash::make('student123'),
                    'role'     => 'student',
                ]
            );
        }

        $this->command->info('✅  Student accounts seeded! Password: student123');
    }
}