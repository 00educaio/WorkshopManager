<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\SchoolClassOrigin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

      $Sorigins = [
            'Frei Damião',
            'Fatima de Lira',
            'Paulo Bandeira',
            'Outro',
        ];

        foreach ($Sorigins as $Sorigin) {
            DB::table('school_class_origins')->insert([
                'name' => $Sorigin,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $origins = DB::table('school_class_origins')->pluck('id')->toArray();

        $classes = [
            // Ensino Fundamental I
            '1º Ano A', '1º Ano B', '2º Ano A', '3º Ano A', '4º Ano A', '5º Ano A',
            // Ensino Fundamental II
            '6º Ano A', '6º Ano B', '7º Ano A', '8º Ano A', '9º Ano A',
            // Ensino Médio
            '1ª Série A', '1ª Série B', '2ª Série A', '3ª Série A',
            // EJA
            'EJA I', 'EJA II', 'EJA III',
        ];

        $originMap = [
            '1º Ano' => 1, '2º Ano' => 1, '3º Ano' => 1, '4º Ano' => 1, '5º Ano' => 1,
            '6º Ano' => 2, '7º Ano' => 2, '8º Ano' => 2, '9º Ano' => 2,
            '1ª Série' => 3, '2ª Série' => 3, '3ª Série' => 3,
        ];

        foreach ($classes as $class) {
            $originId = $originMap[Str::before($class, ' ')] ?? $originMap[substr($class, 0, 3)] ?? $origins[array_rand($origins)];

            DB::table('school_classes')->insert([
                'name' => $class,
                'school_class_origin_id' => $originId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // SchoolClassOrigin::factory()->create([
        //     'id' => 1,
        //     'name' => 'Origin X',
        // ]);

        // SchoolClass::factory()->create([
        //     'name' => 'Class A',
        //     'school_class_origin_id' => 1,
        // ]);

        // SchoolClass::factory()->create([
        //     'name' => 'Class B',
        //     'school_class_origin_id' => 1,
        // ]);
    }
}
