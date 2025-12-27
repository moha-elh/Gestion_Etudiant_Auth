<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Create Main Admin
        User::create([
            'name' => 'Main Admin',
            'email' => 'admin@ensat.ac.ma',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Create 3 Additional Admins
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Admin User $i",
                'email' => "admin$i@ensat.ac.ma",
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        // 3. Create Main Student
        $mainStudent = User::create([
            'name' => 'Main Student',
            'email' => 'student@ensat.ac.ma',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
        Student::create([
            'user_id' => $mainStudent->id,
            'cne' => 'D13000000',
            'sector' => 'G.Info',
            'city' => 'Tetouan',
        ]);

        // 4. Create 10 Additional Students
        $cities = ['Tetouan', 'Tangier', 'Casablanca', 'Rabat', 'Fes'];
        $sectors = ['G.Info', 'G.Indus', 'G.Civil', 'G.Telecom', 'G.Eco'];

        for ($i = 1; $i <= 10; $i++) {
            $studentUser = User::create([
                'name' => "Student User $i",
                'email' => "student$i@ensat.ac.ma",
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $studentUser->id,
                'cne' => 'D13' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'sector' => $sectors[array_rand($sectors)],
                'city' => $cities[array_rand($cities)],
            ]);
        }
    }
}
