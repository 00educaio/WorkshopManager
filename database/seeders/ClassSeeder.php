<?php

namespace Database\Seeders;

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
            'Bradão Lima',
            'Outro'
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
            'Sensibilidade', 'Diversidade', 'Força', 'Conquista', 'Futuro', 'Confiança',
            'Cooperação', 'Coletividade', 'Convivência', 'Luz', 'Superaçao',
            'Determinação', 'Autentidade', 'Energia', 'Representação',
            'Possibilidades', 'Expressão', 'Experiência',
        ];

        foreach ($classes as $class) {
            $originId = $origins[array_rand($origins)];

            DB::table('school_classes')->insert([
                'name' => $class,
                'school_class_origin_id' => $originId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
