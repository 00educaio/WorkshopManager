<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('pt_BR');
        $instructorIds = DB::table('users')->where('role', 'instructor')->pluck('id')->toArray();
        $schoolClassIds = DB::table('school_classes')->pluck('id')->toArray();

        $workshopTimes = [
            '08:00',
            '08:45',
            '09:30',
            '10:15',
            '13:00',
            '13:45',
            '14:30',
            '15:15',
        ];

        $workshopThemes = [
            'Dança',
            'Música',
            'Literatura',
            'Socialização',
            'Fotografia',
            'Artesanato',
            'Robotica',
            'Tecnologia',
        ];

        // Vamos criar 30 relatórios de exemplo (cerca de 6 semanas)
        for ($i = 0; $i < 30; $i++) {
            $reportDate = $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d');

            $reportId = (string) Str::uuid();

            DB::table('workshop_reports')->insert([
                'id'                     => $reportId,
                'report_date'            => $reportDate,
                'extra_activities'       => $faker->boolean(30),
                'extra_activities_description' => $faker->boolean(30) ? $faker->paragraph(2) : null,
                'materials_provided'     => $faker->boolean(90),
                'grid_provided'          => $faker->boolean(85),
                'observations'           => $faker->optional(0.7)->paragraph(3),
                'feedback'               => $faker->paragraph(4),
                'instructor_id'         => $faker->randomElement($instructorIds),
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);

            // Para cada relatório, associar de 2 a 6 turmas com horários diferentes
            $classesInReport = $faker->randomElements(
                $schoolClassIds,
                $faker->numberBetween(4, count($schoolClassIds))
            );

            foreach ($classesInReport as $classId) {
                DB::table('workshop_report_school_classes')->insert([
                    'id'                 => (string) Str::uuid(),
                    'time'               => $faker->randomElement($workshopTimes), // ex: 14:30
                    'workshop_theme'     => $faker->randomElement($workshopThemes),
                    'workshop_report_id' => $reportId,
                    'school_class_id'    => $classId,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }
}