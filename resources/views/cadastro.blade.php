<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Clone - Cadastro</title>
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
            --success-color: #2ecc71;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text-color);
            padding: 20px;
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
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 10px;
            background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 10px;
            text-align: left;
        }

        .input-group input, .input-group textarea {
            width: 100%;
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px;
            font-size: 13px;
            outline: none;
            transition: all 0.2s ease;
        }
        
        .input-group textarea {
            resize: none;
            height: 60px;
        }

        .input-group input:focus, .input-group textarea:focus {
            border-color: #a8a8a8;
        }

        .helper-text {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 3px;
            margin-bottom: 10px;
            display: block;
            text-align: left;
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
            margin-top: 10px;
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
            padding: 10px;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: left;
        }
        .alert.error { background-color: var(--error-color); }
        .alert.success { background-color: var(--success-color); }
        
        .error-list {
            margin-top: 5px;
            margin-left: 15px;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-container">
            <div class="logo">Instagram</div>
            <p class="subtitle">Cadastre-se para ver fotos e vídeos dos seus amigos.</p>
            
            <div class="alert" id="alertBox"></div>

            <form id="registerForm">
                <div class="input-group" style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 1px solid #dbdbdb; padding-bottom: 15px;">
                    <div style="flex: 1;">
                        <span class="helper-text" style="font-size: 11px; color: #8e8e8e; display: block; text-align: left; margin-bottom: 3px; margin-top: 0;">IP do Servidor</span>
                        <input type="text" id="server_ip" placeholder="ex: 192.168.1.15" value="localhost" required>
                    </div>
                    <div style="width: 80px;">
                        <span class="helper-text" style="font-size: 11px; color: #8e8e8e; display: block; text-align: left; margin-bottom: 3px; margin-top: 0;">Porta</span>
                        <input type="text" id="server_port" placeholder="8000" value="24900" required>
                    </div>
                </div>

                <div class="input-group">
                    <input type="email" id="email" placeholder="E-mail" required maxlength="35">
                </div>
                <div class="input-group">
                    <input type="text" id="nome_completo" placeholder="Nome completo" required maxlength="60">
                </div>
                <div class="input-group">
                    <input type="text" id="usuario" placeholder="Nome de usuário" required maxlength="30">
                    <span class="helper-text">Apenas letras minúsculas, números e underline (_)</span>
                </div>
                <div class="input-group">
                    <input type="password" id="senha" placeholder="Senha" required minlength="8" maxlength="24">
                </div>
                <div class="input-group">
                    <textarea id="biografia" placeholder="Biografia (opcional)" maxlength="150"></textarea>
                </div>
                <div class="input-group">
                    <input type="url" id="foto" placeholder="URL da Foto de Perfil (opcional)">
                </div>
                <button type="submit" id="submitBtn">Cadastre-se</button>
            </form>
        </div>

        <div class="signup-container">
            <p>Tem uma conta? <a href="/login">Conecte-se</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Restore previous IP/Port if exists
            const savedIp = localStorage.getItem('server_ip');
            const savedPort = localStorage.getItem('server_port');
            if (savedIp) document.getElementById('server_ip').value = savedIp;
            if (savedPort) document.getElementById('server_port').value = savedPort;
        });

        document.getElementById('registerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const btn = document.getElementById('submitBtn');
            const alertBox = document.getElementById('alertBox');
            
            const ip = document.getElementById('server_ip').value.trim();
            const port = document.getElementById('server_port').value.trim();

            // Save IP and Port configuration
            localStorage.setItem('server_ip', ip);
            localStorage.setItem('server_port', port);
            
            const baseUrl = `http://${ip}:${port}`;
            
            const payload = {
                email: document.getElementById('email').value,
                nome_completo: document.getElementById('nome_completo').value,
                usuario: document.getElementById('usuario').value,
                senha: document.getElementById('senha').value,
                biografia: document.getElementById('biografia').value,
                foto: document.getElementById('foto').value,
            };

            btn.disabled = true;
            btn.innerText = "Cadastrando...";
            alertBox.style.display = 'none';
            alertBox.className = 'alert';
            alertBox.innerHTML = '';

            try {
                const response = await fetch(`${baseUrl}/api/usuarios`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok && result.status === 'sucesso') {
                    alertBox.innerText = "Cadastro realizado! Redirecionando para login...";
                    alertBox.classList.add('success');
                    alertBox.style.display = 'block';
                    
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 2000);
                } else {
                    let errorHtml = `<strong>${result.mensagem || "Erro no cadastro"}</strong>`;
                    
                    if(result.dados && Object.keys(result.dados).length > 0) {
                        errorHtml += '<ul class="error-list">';
                        for(let key in result.dados) {
                            errorHtml += `<li>${result.dados[key][0]}</li>`;
                        }
                        errorHtml += '</ul>';
                    }
                    
                    alertBox.innerHTML = errorHtml;
                    alertBox.classList.add('error');
                    alertBox.style.display = 'block';
                    btn.disabled = false;
                    btn.innerText = "Cadastre-se";
                }
            } catch (error) {
                alertBox.innerText = `Erro de conexão com o servidor ${baseUrl}. Verifique o IP e Porta.`;
                alertBox.classList.add('error');
                alertBox.style.display = 'block';
                btn.disabled = false;
                btn.innerText = "Cadastre-se";
            }
        });
    </script>
</body>
</html>
