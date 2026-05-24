<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Clone - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #fafafa;
            --container-bg: #ffffff;
            --border-color: #dbdbdb;
            --text-color: #262626;
            --text-muted: #8e8e8e;
            --primary-color: #0095f6;
            --primary-hover: #1877f2;
            --error-color: #ed4956;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: var(--text-color);
        }

        .login-wrapper {
            width: 100%;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container, .signup-container {
            background-color: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 30px 40px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .logo {
            font-family: 'Inter', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 30px;
            background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-group {
            margin-bottom: 15px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 12px 10px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
        }

        .input-group input:focus {
            border-color: #a8a8a8;
        }

        button {
            width: 100%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s;
            margin-top: 5px;
        }

        button:hover {
            background-color: var(--primary-hover);
        }
        
        button:active {
            transform: scale(0.98);
        }

        button:disabled {
            background-color: #b2dffc;
            cursor: not-allowed;
        }

        .signup-container p {
            font-size: 14px;
        }

        .signup-container a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .alert {
            display: none;
            color: white;
            background-color: var(--error-color);
            padding: 10px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo">Instagram</div>
            
            <div class="alert" id="errorAlert"></div>

            <form id="loginForm">
                <div class="input-group" style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #dbdbdb; padding-bottom: 15px;">
                    <div style="flex: 1;">
                        <span class="helper-text" style="font-size: 11px; color: #8e8e8e; display: block; text-align: left; margin-bottom: 3px;">IP do Servidor</span>
                        <input type="text" id="server_ip" placeholder="ex: 192.168.1.15" value="localhost" required>
                    </div>
                    <div style="width: 80px;">
                        <span class="helper-text" style="font-size: 11px; color: #8e8e8e; display: block; text-align: left; margin-bottom: 3px;">Porta</span>
                        <input type="text" id="server_port" placeholder="24900" value="24900" required>
                    </div>
                </div>

                <div class="input-group">
                    <input type="text" id="usuario" placeholder="Nome de usuário" required autocomplete="username">
                </div>
                <div class="input-group">
                    <input type="password" id="senha" placeholder="Senha" required autocomplete="current-password">
                </div>
                <button type="submit" id="submitBtn">Entrar</button>
            </form>
        </div>

        <div class="signup-container">
            <p>Não tem uma conta? <a href="/cadastro">Cadastre-se</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const token = localStorage.getItem('jwt_token');
            if(token) {
                window.location.href = '/perfil';
            }
            
            // Restore previous IP/Port if exists
            const savedIp = localStorage.getItem('server_ip');
            const savedPort = localStorage.getItem('server_port');
            if (savedIp) document.getElementById('server_ip').value = savedIp;
            if (savedPort) document.getElementById('server_port').value = savedPort;
        });

        document.getElementById('loginForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = document.getElementById('submitBtn');
            const alertBox = document.getElementById('errorAlert');
            
            const ip = document.getElementById('server_ip').value.trim();
            const port = document.getElementById('server_port').value.trim();
            const usuario = document.getElementById('usuario').value;
            const senha = document.getElementById('senha').value;

            // Save IP and Port configuration
            localStorage.setItem('server_ip', ip);
            localStorage.setItem('server_port', port);
            
            const baseUrl = `http://${ip}:${port}`;

            btn.disabled = true;
            btn.innerText = "Entrando...";
            alertBox.style.display = 'none';

            try {
                const response = await fetch(`${baseUrl}/usuarios/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ usuario, senha })
                });

                const result = await response.json();

                if (response.ok && result.status === 'sucesso') {
                    // Save token and user details
                    localStorage.setItem('jwt_token', result.dados.token);
                    localStorage.setItem('user_id', result.dados.usuario.id);
                    localStorage.setItem('user_is_admin', result.dados.usuario.is_admin ? '1' : '0');
                    localStorage.setItem('api_base_url', baseUrl);
                    
                    window.location.href = '/perfil';
                } else {
                    let errorMsg = result.mensagem || "Erro ao fazer login.";
                    alertBox.innerText = errorMsg;
                    alertBox.style.display = 'block';
                }
            } catch (error) {
                alertBox.innerText = `Erro de conexão com o servidor ${baseUrl}. Verifique o IP e Porta.`;
                alertBox.style.display = 'block';
            } finally {
                btn.disabled = false;
                btn.innerText = "Entrar";
            }
        });
    </script>
</body>
</html>
