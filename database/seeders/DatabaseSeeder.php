<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\SchoolClassOrigin;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_active' => true,
        ]);
        SchoolClassOrigin::factory()->create([
            'id' => 1,
            'name' => 'Origin X',
        ]);

        SchoolClass::factory()->create([
            'name' => 'Class A',
            'school_class_origin_id' => 1,
        ]);

        SchoolClass::factory()->create([
            'name' => 'Class B',
            'school_class_origin_id' => 1,
        ]);
    }
}
