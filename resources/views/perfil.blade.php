<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Clone - Perfil</title>
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
            --header-height: 60px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        header {
            background-color: var(--container-bg);
            border-bottom: 1px solid var(--border-color);
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-link {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid var(--primary-color);
            border-radius: 6px;
            transition: all 0.2s;
        }

        .admin-link:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
        }

        .main-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 30px;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 20px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #efefef;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .user-info h2 { font-size: 20px; margin-bottom: 5px; }
        .user-info p { color: var(--text-muted); font-size: 14px; }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .input-group input, .input-group textarea {
            width: 100%;
            background: #fafafa;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px;
            font-size: 14px;
            outline: none;
        }

        .input-group textarea { resize: none; height: 80px; }

        .input-group input:focus, .input-group textarea:focus {
            border-color: #a8a8a8;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn {
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary { background-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        
        .btn-danger { background-color: var(--error-color); color: white; }
        .btn-danger:hover { background-color: #c93641; }

        .alert {
            display: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 14px;
            margin-bottom: 20px;
            color: white;
        }
        .alert.error { background-color: var(--error-color); }
        .alert.success { background-color: var(--success-color); }

        .error-list { margin-top: 5px; margin-left: 20px; font-size: 13px; }
    </style>
</head>
<body>

    <header>
        <div class="logo" style="cursor:pointer" onclick="window.location.href='/feed'">Instagram</div>
        <div class="header-actions">
            <a href="/feed" style="color:var(--primary-color);font-weight:600;font-size:14px;text-decoration:none;padding:6px 12px;border:1px solid var(--primary-color);border-radius:6px;transition:all 0.2s">Feed</a>
            <a href="/admin" class="admin-link" id="adminLink">Painel ADM</a>
            <button class="logout-btn" onclick="logout()">Sair</button>
        </div>
    </header>

    <div class="main-container">
        <div class="alert" id="alertBox"></div>

        <div class="profile-header">
            <img src="" alt="Avatar" class="avatar" id="avatarImg">
            <div class="user-info">
                <h2 id="displayUser">carregando...</h2>
                <p id="displayEmail">carregando...</p>
            </div>
        </div>

        <form id="profileForm">
            <div class="input-group">
                <label>Nome Completo</label>
                <input type="text" id="nome_completo" required maxlength="60">
            </div>
            <div class="input-group">
                <label>Usuário</label>
                <input type="text" id="usuario" required maxlength="30">
            </div>
            <div class="input-group">
                <label>E-mail</label>
                <input type="email" id="email" required maxlength="35">
            </div>
            <div class="input-group">
                <label>Biografia</label>
                <textarea id="biografia" maxlength="150"></textarea>
            </div>
            <div class="input-group">
                <label>Foto de Perfil</label>
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                    <img id="fotoPreview" src="" style="width:64px;height:64px;border-radius:50%;object-fit:cover;border:2px solid var(--border-color);background:#efefef" alt="Preview">
                    <div style="flex:1">
                        <input type="file" id="fotoInput" accept=".jpg,.jpeg,.png" style="font-size:13px">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px">JPG, JPEG ou PNG (máx. 5MB)</div>
                    </div>
                </div>
                <input type="hidden" id="foto" value="">
            </div>
            <div class="input-group">
                <label>Nova Senha (deixe em branco para não alterar)</label>
                <input type="password" id="senha" minlength="8" maxlength="24">
            </div>

            <div class="actions">
                <button type="button" class="btn btn-danger" onclick="deleteAccount()">Excluir Conta</button>
                <button type="submit" class="btn btn-primary" id="saveBtn">Salvar Alterações</button>
            </div>
        </form>
    </div>

    <script>
        const token = localStorage.getItem('jwt_token');
        const userId = localStorage.getItem('user_id');
        const isAdmin = localStorage.getItem('user_is_admin') === '1';
        const apiBaseUrl = localStorage.getItem('api_base_url') || window.location.origin;

        // Check authentication
        if (!token || !userId) {
            window.location.href = '/login';
        }



        const authHeaders = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };

        const alertBox = document.getElementById('alertBox');

        function showAlert(msg, type, details = null) {
            alertBox.className = `alert ${type}`;
            let html = `<strong>${msg}</strong>`;
            if (details && typeof details === 'object' && Object.keys(details).length > 0) {
                html += '<ul class="error-list">';
                for(let key in details) {
                    if (Array.isArray(details[key])) {
                        html += `<li>${details[key][0]}</li>`;
                    } else {
                        html += `<li>${details[key]}</li>`;
                    }
                }
                html += '</ul>';
            }
            alertBox.innerHTML = html;
            alertBox.style.display = 'block';
            setTimeout(() => alertBox.style.display = 'none', 5000);
        }

        // Load profile data
        async function loadProfile() {
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${userId}`, { headers: authHeaders });
                const result = await res.json();

                if (res.ok && result.status === 'sucesso') {
                    const data = result.dados;
                    document.getElementById('displayUser').innerText = data.nome;
                    document.getElementById('displayEmail').innerText = '@' + data.usuario;
                    
                    document.getElementById('nome_completo').value = data.nome;
                    document.getElementById('usuario').value = data.usuario;
                    document.getElementById('email').value = data.email;
                    document.getElementById('biografia').value = data.biografia || '';
                    document.getElementById('foto').value = data.foto_url || '';
                    
                    const fotoSrc = (data.foto_url && data.foto_url.startsWith('data:image'))
                        ? data.foto_url
                        : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.nome) + '&background=efefef&color=262626';
                    document.getElementById('avatarImg').src = fotoSrc;
                    document.getElementById('fotoPreview').src = fotoSrc;
                } else {
                    if (res.status === 401) logout();
                    if (res.status === 403) {
                        showAlert(result.mensagem || "Acesso negado", "error");
                    } else {
                        showAlert(result.mensagem || "Erro ao carregar perfil", "error");
                    }
                }
            } catch (err) {
                showAlert("Erro de conexão", "error");
            }
        }

        // Update profile — uses PATCH
        document.getElementById('profileForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = document.getElementById('saveBtn');
            btn.disabled = true;
            btn.innerText = "Salvando...";

            const payload = {
                nome: document.getElementById('nome_completo').value,
                usuario: document.getElementById('usuario').value,
                email: document.getElementById('email').value,
                biografia: document.getElementById('biografia').value,
                foto: document.getElementById('foto').value,
            };

            const senha = document.getElementById('senha').value;
            if (senha) payload.senha = senha;

            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${userId}`, {
                    method: 'PATCH',
                    headers: authHeaders,
                    body: JSON.stringify(payload)
                });
                const result = await res.json();

                if (res.ok && result.status === 'sucesso') {
                    showAlert("Perfil atualizado com sucesso!", "success");
                    document.getElementById('senha').value = '';
                    loadProfile();
                } else {
                    if (res.status === 403) {
                        showAlert(result.mensagem || "Acesso negado — você não pode editar este perfil", "error");
                    } else {
                        showAlert(result.mensagem || "Erro ao atualizar", "error", result.dados);
                    }
                }
            } catch (err) {
                showAlert("Erro de conexão", "error");
            } finally {
                btn.disabled = false;
                btn.innerText = "Salvar Alterações";
            }
        });

        // Delete account
        async function deleteAccount() {
            if(!confirm("Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.")) return;

            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${userId}`, {
                    method: 'DELETE',
                    headers: authHeaders
                });
                const result = await res.json();
                
                if (res.ok) {
                    alert("Conta excluída com sucesso.");
                    localStorage.clear();
                    window.location.href = '/cadastro';
                } else {
                    if (res.status === 403) {
                        showAlert(result.mensagem || "Acesso negado — você não pode excluir este perfil", "error");
                    } else {
                        showAlert(result.mensagem || "Erro ao excluir conta", "error");
                    }
                }
            } catch (err) {
                showAlert("Erro de conexão", "error");
            }
        }

        // Logout
        async function logout() {
            try {
                await fetch(`${apiBaseUrl}/usuarios/logout`, {
                    method: 'POST',
                    headers: authHeaders
                });
            } catch (e) {} // Ignore error, just clear local state
            
            localStorage.clear();
            window.location.href = '/login';
        }

        // Foto upload handler (Base64)
        document.getElementById('fotoInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                showAlert('Formato inválido! Use JPG, JPEG ou PNG.', 'error');
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                showAlert('Imagem muito grande! Máximo 5MB.', 'error');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                document.getElementById('foto').value = ev.target.result;
                document.getElementById('fotoPreview').src = ev.target.result;
                document.getElementById('avatarImg').src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });

        // Initialize
        loadProfile();
    </script>
</body>
</html>
