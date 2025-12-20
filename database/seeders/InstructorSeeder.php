<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class InstructorSeeder extends Seeder
{
    public function run(): void
    {        
        $instructorNames = [
            'Caroline', 'Pierre', 'Davi', 'Douglas', 'Israel', 'Theo', 
            'Mirella', 'Genival', 'Higor', 'Roberta', 'Caio', 'Bruna'
        ];

        foreach ($instructorNames as $name) {
            // Verifica se já existe para não dar erro de Duplicate Entry
            if (User::where('email', strtolower($name) . '@gmail.com')->exists()) {
                continue;
            }

            User::create([
                'name' => $name,
                // Gera um telefone aleatório simples sem depender do Faker
                'phone' => '119' . rand(10000000, 99999999),
                // Gera um CPF válido (algoritmo simples) ou apenas números aleatórios se não validar formato estrito
                'cpf' => $this->generateCpf(), 
                'avatar' => 'avatars/default-avatar.png',
                'email' => strtolower($name) . '@gmail.com',
                'password' => Hash::make('12345678'), // Hash::make é mais moderno que bcrypt()
                'email_verified_at' => now(),
                'role' => 'instructor',
                // Se tiver UUID na tabela:
                // 'uuid' => Str::uuid(),
            ]);
        }
    }

    /**
     * Função auxiliar para gerar CPF válido sem biblioteca externa
     */
    private function generateCpf()
    {
        $n = [];
        for ($i = 0; $i < 9; $i++) $n[$i] = rand(0, 9);
        
        // Primeiro dígito
        $d1 = 0;
        for ($i = 0, $x = 10; $i < 9; $i++, $x--) $d1 += $n[$i] * $x;
        $d1 = ($d1 % 11 < 2) ? 0 : 11 - ($d1 % 11);
        $n[9] = $d1;
        
        // Segundo dígito
        $d2 = 0;
        for ($i = 0, $x = 11; $i < 10; $i++, $x--) $d2 += $n[$i] * $x;
        $d2 = ($d2 % 11 < 2) ? 0 : 11 - ($d2 % 11);
        $n[10] = $d2;
        
        return implode('', $n);
    }
}