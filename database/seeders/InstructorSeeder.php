<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class InstructorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $instructorNames = [
            'Caroline',
            'Pierre',
            'Davi',
            'Douglas',
            'Israel',
            'Theo',
            'Mirella',
            'Genival',
            'Higor',
        ];

        foreach ($instructorNames as $name) {
          User::factory()->create([
              'name' => $name,
              'email' => $name . '@gmail.com',
              'password' => bcrypt('12345678'),
              'email_verified_at' => now(),
              'role' => 'instructor',
              'is_active' => true,
          ]);
      }

    }
}
