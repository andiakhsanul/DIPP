<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Batch;
use Illuminate\Support\Facades\Hash;

class AdminAndBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User (only if doesn't exist)
        $admin = User::firstOrCreate(
            ['email' => 'admin@dipp.unair.ac.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Admin Profile (only if doesn't exist)
        if (!$admin->profile) {
            UserProfile::create([
                'user_id' => $admin->id,
                'full_name' => 'Administrator DIPP',
                'nidn' => '0000000000',
                'university' => 'Universitas Airlangga',
                'phone_number' => '081234567890',
            ]);
        }

        // Create Sample Batches (only if they don't exist)
        if (Batch::count() == 0) {
            Batch::create([
                'name' => 'Pelatihan Pekerti Batch 1 - 2025',
                'description' => 'Pelatihan Pekerti untuk Dosen Tingkat Pertama',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(35),
                'max_participants' => 50,
                'registration_start' => now(),
                'registration_end' => now()->addDays(25),
                'status' => 'open',
            ]);

            Batch::create([
                'name' => 'Pelatihan Pekerti Batch 2 - 2025',
                'description' => 'Pelatihan Pekerti untuk Dosen Tingkat Lanjutan',
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(65),
                'max_participants' => 40,
                'registration_start' => now()->addDays(10),
                'registration_end' => now()->addDays(55),
                'status' => 'scheduled',
            ]);

            Batch::create([
                'name' => 'Pelatihan AA Batch 1 - 2025',
                'description' => 'Pelatihan Applied Approach untuk Dosen',
                'start_date' => now()->addDays(90),
                'end_date' => now()->addDays(95),
                'max_participants' => 30,
                'registration_start' => now()->addDays(40),
                'registration_end' => now()->addDays(85),
                'status' => 'scheduled',
            ]);
        }

        $this->command->info('Admin user and sample batches created successfully!');
        $this->command->info('Admin credentials:');
        $this->command->info('Email: admin@dipp.unair.ac.id');
        $this->command->info('Password: admin123');
    }
}
