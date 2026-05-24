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
        // Cria usuário administrador padrão (se não existir)
        if (!User::where('usuario', 'admin')->exists()) {
            User::create([
                'nome_completo' => 'Administrador',
                'usuario' => 'admin',
                'email' => 'admin@instagram.com',
                'senha' => 'admin1234',
                'biografia' => 'Administrador do sistema',
                'is_admin' => true,
            ]);
        }

        // Cria usuário comum padrão (se não existir)
        if (!User::where('usuario', 'user_comum')->exists()) {
            User::create([
                'nome_completo' => 'Usuario Comum',
                'usuario' => 'user_comum',
                'email' => 'comum@instagram.com',
                'senha' => 'user1234',
                'biografia' => 'Usuario comum do sistema',
                'is_admin' => false,
            ]);
        }
    }
}
