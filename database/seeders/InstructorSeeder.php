<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class InstructorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $fake = Faker::create('pt_BR');

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
            'Roberta',
            'Caio',
            'Bruna',
            
        ];

        foreach ($instructorNames as $name) {
          User::factory()->create([
              'name' => $name,
              'phone' => $fake->phoneNumber(),
              'cpf' => $fake->cpf(false),
              'avatar' => 'avatars/default-avatar.png',
              'email' => $name . '@gmail.com',
              'password' => bcrypt('12345678'),
              'email_verified_at' => now(),
              'role' => 'instructor',
          ]);
      }

    }
}
