<?php

namespace Database\Seeders;

use App\Models\WorkshopReport;
use App\Models\WorkshopReportSchoolClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Busca IDs existentes
        $instructorIds = DB::table('users')->where('role', 'instructor')->pluck('id')->toArray();
        $schoolClassIds = DB::table('school_classes')->pluck('id')->toArray();

        // Verificação de segurança
        if (empty($instructorIds) || empty($schoolClassIds)) {
            $this->command->warn('Sem instrutores ou turmas para gerar relatórios.');
            return;
        }

        // 2. Dados Estáticos para sorteio
        $workshopTimes = ['08:00', '08:45', '09:30', '10:15', '13:00', '13:45', '14:30', '15:15'];
        
        $workshopThemes = [
            'Dança', 'Música', 'Literatura', 'Socialização', 
            'Fotografia', 'Artesanato', 'Robótica', 'Tecnologia'
        ];

        $texts = [
            'observations' => [
                'Alunos muito participativos hoje.',
                'Houve um pouco de dispersão no início, mas depois focaram.',
                'Atividade realizada com sucesso, todos entregaram o proposto.',
                'Alguns alunos tiveram dificuldade com o material.',
                'Turma agitada, mas produtiva.',
                null, // Chance de ser vazio
                null
            ],
            'feedback' => [
                'A dinâmica de grupo funcionou muito bem para integrar os alunos novos.',
                'Precisamos de mais materiais de pintura para a próxima aula.',
                'O tema foi muito bem recebido, houve bastante debate.',
                'A turma demonstrou grande evolução na coordenação motora.',
                'Foi necessário adaptar a atividade devido ao tempo curto.',
                'Excelente engajamento da turma com a proposta tecnológica.'
            ],
            'extras' => [
                'Realizamos uma dinâmica extra de quebra-gelo.',
                'Fizemos um debate rápido sobre atualidades.',
                'Houve uma apresentação não planejada dos alunos.',
                'Passeio rápido pelo pátio para observação.',
                'Sessão de feedback individual com os alunos.'
            ]
        ];

        // 3. Loop de criação (30 Relatórios)
        for ($i = 0; $i < 30; $i++) {
            
            // Data aleatória nos últimos 90 dias
            $reportDate = Carbon::now()->subDays(rand(0, 90))->format('Y-m-d');
            
            // Sorteio de booleanos com peso (ex: 30% de chance de ter extra)
            $hasExtra = (bool) (rand(1, 100) <= 30); // 30% true
            
            $reportId = (string) Str::uuid();

            WorkshopReport::create([
                'id'                     => $reportId,
                'report_date'            => $reportDate,
                'extra_activities'       => false,
                'extra_activities_description' => $hasExtra ? $texts['extras'][array_rand($texts['extras'])] : null,
                'materials_provided'     => (rand(1, 100) <= 90), // 90% true
                'grid_provided'          => (rand(1, 100) <= 85), // 85% true
                'observations'           => $texts['observations'][array_rand($texts['observations'])],
                'feedback'               => $texts['feedback'][array_rand($texts['feedback'])],
                'instructor_id'          => $instructorIds[array_rand($instructorIds)],
                'created_at'             => now(),
                'updated_at'             => now(),
            ]);

            // 4. Associar Turmas (Sub-loop)
            // Sorteia quantas turmas esse relatório terá (entre 2 e 5, por exemplo)
            // e embaralha o array de IDs para pegar aleatórios únicos
            $shuffledClasses = $schoolClassIds;
            shuffle($shuffledClasses);
            $selectedClasses = array_slice($shuffledClasses, 0, rand(2, 5));

            foreach ($selectedClasses as $classId) {
                WorkshopReportSchoolClass::create([
                    'id'                 => (string) Str::uuid(),
                    'time'               => $workshopTimes[array_rand($workshopTimes)],
                    'workshop_theme'     => $workshopThemes[array_rand($workshopThemes)],
                    'workshop_report_id' => $reportId,
                    'school_class_id'    => $classId,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }
}