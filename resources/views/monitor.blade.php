<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Servidor - Status Online</title>
    <meta http-equiv="refresh" content="15">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #0f172a;
            --surface: #1e293b;
            --surface-hover: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --accent: #3b82f6;
            --accent-glow: rgba(59, 130, 246, 0.5);
            --success: #10b981;
            --danger: #ef4444;
            --border: #334155;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Outfit', sans-serif; }

        body {
            background-color: var(--bg-color);
            color: var(--text-primary);
            padding: 30px;
            background-image: radial-gradient(circle at top right, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(to right, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-refresh {
            background: linear-gradient(135deg, var(--accent) 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px var(--accent-glow);
        }
        
        .btn-refresh:hover { transform: translateY(-2px); box-shadow: 0 6px 20px var(--accent-glow); }

        .grid-layout {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--surface);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .card:hover { transform: translateY(-5px); }

        .card-title {
            font-size: 14px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-value {
            font-size: 36px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .badge {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .info-list { list-style: none; }
        .info-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
            font-size: 15px;
        }
        .info-list li:last-child { border-bottom: none; }
        .info-list span:first-child { color: var(--text-secondary); }
        .info-list span:last-child { font-weight: 600; }

        .section-box {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            margin-bottom: 30px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 18px;
            background: rgba(255,255,255,0.02);
        }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px 24px; text-align: left; border-bottom: 1px solid var(--border); }
        th { font-size: 13px; text-transform: uppercase; color: var(--text-secondary); font-weight: 600; background: rgba(0,0,0,0.2); }
        td { font-size: 15px; color: var(--text-primary); }
        tr:hover td { background: rgba(255,255,255,0.03); }

        .logs-container {
            padding: 20px 24px;
            background-color: #0f172a;
            color: #10b981;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            height: 250px;
            overflow-y: auto;
        }
        .logs-container div { margin-bottom: 8px; word-wrap: break-word; }

        .highlight-ip {
            color: #fca5a5;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Centro de Monitoramento (Servidor)</h1>
        <a href="/servidor" class="btn-refresh">🔄 Atualizar Dados</a>
    </div>

    <!-- Cards Superiores -->
    <div class="grid-layout">
        <!-- Seu Acesso -->
        <div class="card">
            <div class="card-title">Sua Conexão Atual <span class="badge">Online</span></div>
            <div class="card-value" style="font-size: 28px;">{{ $requestIp }}</div>
            <p style="color: var(--text-secondary); margin-top: 10px; font-size: 14px;">Este é o IP de onde você está acessando o painel agora.</p>
        </div>

        <!-- Dados do Banco -->
        <div class="card">
            <div class="card-title">Banco de Dados <span class="badge" style="background: rgba(59,130,246,0.2); color: var(--accent);">{{ strtoupper($dbInfo['driver']) }}</span></div>
            <ul class="info-list" style="margin-top: 15px;">
                <li><span>Database</span> <span>{{ $dbInfo['database'] }}</span></li>
                <li><span>Host</span> <span>{{ $dbInfo['host'] }}:{{ $dbInfo['port'] }}</span></li>
                <li><span>Usuário</span> <span>{{ $dbInfo['username'] }}</span></li>
            </ul>
        </div>

        <!-- Rede LAN -->
        <div class="card">
            <div class="card-title">Acesso Externo (LAN)</div>
            <ul class="info-list" style="margin-top: 15px;">
                <li><span>IP do Servidor</span> <span>{{ $localIp }}</span></li>
                <li><span>Total de Contas</span> <span>{{ $totalUsuarios }}</span></li>
                <li><span>Total de Posts</span> <span>{{ $totalPosts }}</span></li>
                <li><span>Total de Curtidas</span> <span>{{ $totalCurtidas }}</span></li>
            </ul>
            <p style="color: var(--text-secondary); margin-top: 15px; font-size: 13px;">Para testes em outros computadores, peça que acessem: <strong style="color:var(--text-primary);">http://{{ $localIp }}:22000</strong></p>
        </div>
    </div>

    <!-- Usuários e Sessões Online -->
    <div class="section-box">
        <div class="section-header">🌐 Tráfego & Sessões Ativas (Quem está online)</div>
        <table>
            <thead>
                <tr>
                    <th>Sessão ID</th>
                    <th>Endereço IP</th>
                    <th>Navegador / Dispositivo (User Agent)</th>
                    <th>Última Atividade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessoesAtivas as $sessao)
                <tr>
                    <td style="font-family: monospace; color: var(--text-secondary); font-size: 13px;">{{ substr($sessao->id, 0, 15) }}...</td>
                    <td class="{{ $sessao->ip_address == $requestIp ? 'highlight-ip' : '' }}">{{ $sessao->ip_address }} {!! $sessao->ip_address == $requestIp ? '<small>(Você)</small>' : '' !!}</td>
                    <td style="font-size: 13px; color: var(--text-secondary);">{{ Str::limit($sessao->user_agent, 60) }}</td>
                    <td>{{ \Carbon\Carbon::createFromTimestamp($sessao->last_activity)->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: var(--text-secondary);">Nenhum tráfego detectado recentemente.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Usuários Cadastrados -->
    <div class="section-box">
        <div class="section-header">👥 Últimos Usuários Cadastrados no Banco</div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome Completo</th>
                    <th>Usuário (@)</th>
                    <th>Privilégio</th>
                    <th>Data de Cadastro</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios->take(10) as $user)
                <tr>
                    <td>#{{ $user->id }}</td>
                    <td style="font-weight: 500;">{{ $user->nome_completo }}</td>
                    <td style="color: var(--accent);">{{ $user->usuario }}</td>
                    <td>{!! $user->is_admin ? '<span class="badge" style="background: rgba(239,68,68,0.2); color: var(--danger);">Admin</span>' : '<span class="badge" style="background: rgba(59,130,246,0.2); color: var(--accent);">Comum</span>' !!}</td>
                    <td>{{ $user->created_at->timezone('America/Sao_Paulo')->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--text-secondary);">Nenhum usuário cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Logs -->
    <div class="section-box">
        <div class="section-header">🛠️ Logs Nativos do Servidor (laravel.log)</div>
        <div class="logs-container">
            @forelse($logs as $log)
                <div>> {{ $log }}</div>
            @empty
                <div>> [OK] Nenhum erro crítico encontrado. O sistema está rodando perfeitamente.</div>
            @endforelse
        </div>
    </div>

</body>
</html>
