<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Camila',
            'phone' => '11999999999',
            'cpf' => '148.097.744-65',
            'email' => 'camila@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->call([
            InstructorSeeder::class,
            ClassSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
