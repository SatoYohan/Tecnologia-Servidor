<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Curtida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class MonitorController extends Controller
{
    public function index(Request $request)
    {
        // Pega todos os usuários
        $usuarios = User::orderBy('created_at', 'desc')->get();
        $totalUsuarios = $usuarios->count();

        // Estatísticas de Posts e Curtidas (Entrega 3)
        $totalPosts = Post::count();
        $totalCurtidas = Curtida::count();

        // Tenta ler as últimas 20 linhas do laravel.log
        $logPath = storage_path('logs/laravel.log');
        $logs = [];
        
        if (File::exists($logPath)) {
            $lines = file($logPath);
            $logs = array_slice(array_reverse($lines), 0, 20);
        }

        // IP da máquina na rede local
        $localIp = getHostByName(getHostName());

        // IP de quem está acessando o servidor neste momento
        $requestIp = $request->ip();

        // Informações detalhadas do Banco de Dados
        $dbInfo = [
            'database' => DB::connection()->getDatabaseName(),
            'driver'   => DB::connection()->getDriverName(),
            'host'     => DB::connection()->getConfig('host'),
            'port'     => DB::connection()->getConfig('port'),
            'username' => DB::connection()->getConfig('username'),
        ];

        // Busca usuários que estão online agora (através da tabela sessions nativa do Laravel)
        // Pegamos as sessões que tiveram atividade recente
        $sessoesAtivas = DB::table('sessions')
            ->orderBy('last_activity', 'desc')
            ->take(15)
            ->get();

        return view('monitor', [
            'usuarios'       => $usuarios,
            'totalUsuarios'  => $totalUsuarios,
            'totalPosts'     => $totalPosts,
            'totalCurtidas'  => $totalCurtidas,
            'logs'           => $logs,
            'localIp'        => $localIp,
            'requestIp'      => $requestIp,
            'dbInfo'         => $dbInfo,
            'sessoesAtivas'  => $sessoesAtivas
        ]);
    }
}
