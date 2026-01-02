<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'status' => 1,
        ]);

        $user->assignRole('super-admin');

        UserProfile::create([
            'user_id' => $user->id,
            'phone' => '01700000000',
            'dob' => '1990-01-01',
            'gender' => 'Male',
            'nid_number' => '1234567890',
            'passport_number' => 'A1234567',
            'address' => 'Dhaka, Bangladesh',
            'salary' => 50000,
            'salary_type' => 'monthly',
            'employment_type' => 'full-time',
            'joining_date' => '2024-01-01',
            'bank_name' => 'DBBL',
            'bank_account' => '123456789',
            'profile_photo' => null,
            'nid_document' => null,
            'contract_document' => null,
        ]);
    }
}
