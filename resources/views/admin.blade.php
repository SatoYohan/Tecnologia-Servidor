<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Clone - Painel ADM</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-color: #fafafa; --container-bg: #ffffff; --border-color: #dbdbdb;
            --text-color: #262626; --text-muted: #8e8e8e; --primary-color: #0095f6;
            --primary-hover: #1877f2; --error-color: #ed4956; --success-color: #2ecc71;
            --header-height: 60px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: var(--bg-color); color: var(--text-color); }
        header {
            background-color: var(--container-bg); border-bottom: 1px solid var(--border-color);
            height: var(--header-height); display: flex; align-items: center;
            justify-content: space-between; padding: 0 20px; position: sticky; top: 0; z-index: 10;
        }
        .logo {
            font-size: 1.5rem; font-weight: 700;
            background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .header-actions { display: flex; align-items: center; gap: 15px; }
        .header-actions a {
            color: var(--primary-color); font-weight: 600; font-size: 14px;
            text-decoration: none; padding: 6px 12px; border: 1px solid var(--primary-color);
            border-radius: 6px; transition: all 0.2s;
        }
        .header-actions a:hover { background-color: var(--primary-color); color: white; }
        .logout-btn { background: none; border: none; color: var(--primary-color); font-weight: 600; font-size: 14px; cursor: pointer; }
        .main-container {
            max-width: 900px; margin: 30px auto; padding: 0 20px;
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
        .card {
            background-color: var(--container-bg); border: 1px solid var(--border-color);
            border-radius: 8px; padding: 25px; margin-bottom: 20px;
        }
        .card h2 { font-size: 18px; margin-bottom: 15px; }
        .alert {
            display: none; padding: 10px; border-radius: 4px; font-size: 14px;
            margin-bottom: 15px; color: white;
        }
        .alert.error { background-color: var(--error-color); }
        .alert.success { background-color: var(--success-color); }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th, td { text-align: left; padding: 10px 8px; border-bottom: 1px solid var(--border-color); }
        th { font-weight: 600; color: var(--text-muted); font-size: 12px; text-transform: uppercase; }
        .badge {
            display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;
        }
        .badge-admin { background: #e8f5e9; color: #2e7d32; }
        .badge-user { background: #e3f2fd; color: #1565c0; }
        .btn {
            border: none; border-radius: 4px; padding: 6px 12px; font-weight: 600;
            font-size: 12px; cursor: pointer; transition: all 0.2s; margin: 0 2px;
        }
        .btn-view { background: #e3f2fd; color: #1565c0; }
        .btn-edit { background: #fff3e0; color: #e65100; }
        .btn-delete { background: #ffebee; color: #c62828; }
        .btn-view:hover { background: #bbdefb; }
        .btn-edit:hover { background: #ffe0b2; }
        .btn-delete:hover { background: #ffcdd2; }
        /* Modal */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 100; justify-content: center; align-items: center;
        }
        .modal-overlay.active { display: flex; }
        .modal {
            background: white; border-radius: 12px; padding: 30px; width: 90%; max-width: 500px;
            max-height: 80vh; overflow-y: auto; animation: fadeIn 0.3s ease-out;
        }
        .modal h3 { margin-bottom: 20px; font-size: 18px; }
        .modal .input-group { margin-bottom: 12px; }
        .modal .input-group label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 4px; }
        .modal .input-group input, .modal .input-group textarea {
            width: 100%; background: #fafafa; border: 1px solid var(--border-color);
            border-radius: 4px; padding: 8px; font-size: 13px; outline: none;
        }
        .modal .input-group textarea { resize: none; height: 60px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }
        .btn-cancel { background: #f5f5f5; color: #333; padding: 8px 16px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .btn-save { background: var(--primary-color); color: white; padding: 8px 16px; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; }
        .btn-save:hover { background: var(--primary-hover); }
        .detail-row { display: flex; padding: 8px 0; border-bottom: 1px solid #f0f0f0; }
        .detail-label { font-weight: 600; width: 120px; font-size: 13px; color: var(--text-muted); }
        .detail-value { flex: 1; font-size: 14px; }
        .error-list { margin-top: 5px; margin-left: 15px; font-size: 12px; }
    </style>
</head>
<body>
    <header>
        <div class="logo">Instagram <span style="font-size: 14px; font-weight: 400; -webkit-text-fill-color: #8e8e8e;">ADM</span></div>
        <div class="header-actions">
            <a href="/perfil">Meu Perfil</a>
            <button class="logout-btn" onclick="logout()">Sair</button>
        </div>
    </header>

    <div class="main-container">
        <div class="alert" id="alertBox"></div>

        <div class="card">
            <h2>Gerenciamento de Usuários</h2>
            <table>
                <thead>
                    <tr><th>ID</th><th>Nome</th><th>Usuário</th><th>Email</th><th>Tipo</th><th>Ações</th></tr>
                </thead>
                <tbody id="usersTable">
                    <tr><td colspan="6" style="text-align:center;color:var(--text-muted);">Carregando...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Ver Detalhes -->
    <div class="modal-overlay" id="viewModal">
        <div class="modal">
            <h3>Detalhes do Usuário</h3>
            <div id="viewContent"></div>
            <div class="modal-actions">
                <button class="btn-cancel" onclick="closeModal('viewModal')">Fechar</button>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <h3>Editar Usuário</h3>
            <div class="alert" id="editAlertBox" style="display:none;"></div>
            <form id="editForm">
                <input type="hidden" id="edit_id">
                <div class="input-group"><label>Nome Completo</label><input type="text" id="edit_nome" maxlength="60"></div>
                <div class="input-group"><label>Usuário</label><input type="text" id="edit_usuario" maxlength="30"></div>
                <div class="input-group"><label>E-mail</label><input type="email" id="edit_email" maxlength="35"></div>
                <div class="input-group"><label>Biografia</label><textarea id="edit_biografia" maxlength="150"></textarea></div>
                <div class="input-group"><label>URL da Foto</label><input type="text" id="edit_foto"></div>
                <div class="input-group"><label>Nova Senha (opcional)</label><input type="password" id="edit_senha" minlength="8" maxlength="24"></div>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Cancelar</button>
                    <button type="submit" class="btn-save" id="editSaveBtn">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('jwt_token');
        const userId = localStorage.getItem('user_id');
        const isAdmin = localStorage.getItem('user_is_admin') === '1';
        const apiBaseUrl = localStorage.getItem('api_base_url') || window.location.origin;

        if (!token || !userId) { window.location.href = '/login'; }
        if (!isAdmin) { window.location.href = '/perfil'; }

        const authHeaders = { 'Content-Type': 'application/json', 'Authorization': `Bearer ${token}` };
        const alertBox = document.getElementById('alertBox');

        function showAlert(msg, type, el = alertBox) {
            el.className = `alert ${type}`;
            el.innerHTML = `<strong>${msg}</strong>`;
            el.style.display = 'block';
            setTimeout(() => el.style.display = 'none', 5000);
        }

        function closeModal(id) { document.getElementById(id).classList.remove('active'); }

        // LIST USERS
        async function loadUsers() {
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios`, { headers: authHeaders });
                const result = await res.json();
                const tbody = document.getElementById('usersTable');

                if (res.ok && result.status === 'sucesso') {
                    const users = result.dados.usuarios;
                    tbody.innerHTML = users.map(u => `
                        <tr>
                            <td>${u.id}</td>
                            <td>${u.nome}</td>
                            <td>@${u.usuario}</td>
                            <td>${u.email}</td>
                            <td><span class="badge ${u.is_admin ? 'badge-admin' : 'badge-user'}">${u.is_admin ? 'Admin' : 'Usuário'}</span></td>
                            <td>
                                <button class="btn btn-view" onclick="viewUser(${u.id})">Ver</button>
                                <button class="btn btn-edit" onclick="editUser(${u.id})">Editar</button>
                                <button class="btn btn-delete" onclick="deleteUser(${u.id}, '${u.usuario}')">Excluir</button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    if (res.status === 401) logout();
                    if (res.status === 403) showAlert(result.mensagem || 'Acesso negado', 'error');
                    else tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Nenhum usuário encontrado</td></tr>';
                }
            } catch (err) {
                showAlert('Erro de conexão ao carregar usuários', 'error');
            }
        }

        // VIEW USER
        async function viewUser(id) {
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${id}`, { headers: authHeaders });
                const result = await res.json();
                if (res.ok && result.status === 'sucesso') {
                    const d = result.dados;
                    document.getElementById('viewContent').innerHTML = `
                        <div class="detail-row"><span class="detail-label">ID</span><span class="detail-value">${d.id}</span></div>
                        <div class="detail-row"><span class="detail-label">Nome</span><span class="detail-value">${d.nome}</span></div>
                        <div class="detail-row"><span class="detail-label">Usuário</span><span class="detail-value">@${d.usuario}</span></div>
                        <div class="detail-row"><span class="detail-label">Email</span><span class="detail-value">${d.email}</span></div>
                        <div class="detail-row"><span class="detail-label">Biografia</span><span class="detail-value">${d.biografia || '—'}</span></div>
                        <div class="detail-row"><span class="detail-label">Tipo</span><span class="detail-value">${d.is_admin ? 'Administrador' : 'Usuário Comum'}</span></div>
                    `;
                    document.getElementById('viewModal').classList.add('active');
                } else {
                    showAlert(result.mensagem || 'Erro ao carregar usuário', 'error');
                }
            } catch (err) { showAlert('Erro de conexão', 'error'); }
        }

        // EDIT USER — open modal
        async function editUser(id) {
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${id}`, { headers: authHeaders });
                const result = await res.json();
                if (res.ok && result.status === 'sucesso') {
                    const d = result.dados;
                    document.getElementById('edit_id').value = d.id;
                    document.getElementById('edit_nome').value = d.nome;
                    document.getElementById('edit_usuario').value = d.usuario;
                    document.getElementById('edit_email').value = d.email;
                    document.getElementById('edit_biografia').value = d.biografia || '';
                    document.getElementById('edit_foto').value = d.foto_url || '';
                    document.getElementById('edit_senha').value = '';
                    document.getElementById('editModal').classList.add('active');
                } else {
                    showAlert(result.mensagem || 'Erro ao carregar dados', 'error');
                }
            } catch (err) { showAlert('Erro de conexão', 'error'); }
        }

        // EDIT USER — submit (PATCH)
        document.getElementById('editForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('edit_id').value;
            const btn = document.getElementById('editSaveBtn');
            const editAlert = document.getElementById('editAlertBox');
            btn.disabled = true; btn.innerText = 'Salvando...';

            const payload = {
                nome: document.getElementById('edit_nome').value,
                usuario: document.getElementById('edit_usuario').value,
                email: document.getElementById('edit_email').value,
                biografia: document.getElementById('edit_biografia').value,
                foto: document.getElementById('edit_foto').value,
            };
            const senha = document.getElementById('edit_senha').value;
            if (senha) payload.senha = senha;

            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${id}`, {
                    method: 'PATCH', headers: authHeaders, body: JSON.stringify(payload)
                });
                const result = await res.json();
                if (res.ok && result.status === 'sucesso') {
                    closeModal('editModal');
                    showAlert('Usuário atualizado com sucesso!', 'success');
                    loadUsers();
                } else {
                    let msg = result.mensagem || 'Erro ao atualizar';
                    if (result.dados && typeof result.dados === 'object' && Object.keys(result.dados).length > 0) {
                        msg += ': ';
                        for (let k in result.dados) {
                            msg += Array.isArray(result.dados[k]) ? result.dados[k][0] + ' ' : result.dados[k] + ' ';
                        }
                    }
                    showAlert(msg, 'error', editAlert);
                }
            } catch (err) { showAlert('Erro de conexão', 'error', editAlert); }
            finally { btn.disabled = false; btn.innerText = 'Salvar'; }
        });

        // DELETE USER
        async function deleteUser(id, username) {
            if (!confirm(`Tem certeza que deseja excluir o usuário @${username}?`)) return;
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${id}`, {
                    method: 'DELETE', headers: authHeaders
                });
                const result = await res.json();
                if (res.ok) {
                    showAlert('Usuário excluído com sucesso!', 'success');
                    loadUsers();
                } else {
                    showAlert(result.mensagem || 'Erro ao excluir usuário', 'error');
                }
            } catch (err) { showAlert('Erro de conexão', 'error'); }
        }

        // LOGOUT
        async function logout() {
            try { await fetch(`${apiBaseUrl}/usuarios/logout`, { method: 'POST', headers: authHeaders }); } catch (e) {}
            localStorage.clear(); window.location.href = '/login';
        }

        loadUsers();
    </script>
</body>
</html>
