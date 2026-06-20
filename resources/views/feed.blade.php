<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Clone - Feed</title>
    <meta name="description" content="Feed de postagens do Instagram Clone">
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
            --heart-color: #ed4956;
            --header-height: 60px;
            --sidebar-width: 280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        /* ===== HEADER ===== */
        header {
            background-color: var(--container-bg);
            border-bottom: 1px solid var(--border-color);
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: -webkit-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: pointer;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link:hover { background-color: #f0f0f0; }
        .nav-link.active { color: var(--primary-color); font-weight: 700; }

        .logout-btn {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            padding: 7px 14px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .logout-btn:hover { border-color: var(--error-color); color: var(--error-color); }

        /* ===== LAYOUT ===== */
        .layout {
            display: flex;
            max-width: 1100px;
            margin: calc(var(--header-height) + 20px) auto 0;
            padding: 0 16px;
            gap: 28px;
        }

        /* ===== SIDEBAR — Lista de Usuários ===== */
        .sidebar {
            width: var(--sidebar-width);
            flex-shrink: 0;
            position: sticky;
            top: calc(var(--header-height) + 20px);
            height: fit-content;
            max-height: calc(100vh - var(--header-height) - 40px);
            overflow-y: auto;
        }

        .sidebar-card {
            background: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            animation: fadeIn 0.4s ease-out;
        }

        .sidebar-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 14px;
        }

        .user-list {
            list-style: none;
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .user-item:hover { background-color: #f8f8f8; }
        .user-item.active { background-color: #eff6ff; }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #efefef;
            background-color: #efefef;
        }

        .user-item-info { flex: 1; min-width: 0; }
        .user-item-name { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-item-username { font-size: 12px; color: var(--text-muted); }

        /* ===== MAIN FEED ===== */
        .main-feed {
            flex: 1;
            max-width: 600px;
            min-width: 0;
        }

        /* ===== NEW POST FORM ===== */
        .new-post-card {
            background: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            animation: fadeIn 0.4s ease-out;
        }

        .new-post-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
        }

        .new-post-header .user-avatar { width: 40px; height: 40px; }

        .new-post-header span {
            font-weight: 600;
            font-size: 14px;
        }

        .image-upload-area {
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 12px;
            position: relative;
            overflow: hidden;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        .image-upload-area:hover { border-color: var(--primary-color); background: #f0f8ff; }
        .image-upload-area.has-image { border-style: solid; padding: 0; }

        .image-upload-area img {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 6px;
        }

        .upload-icon {
            font-size: 32px;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .upload-text {
            font-size: 13px;
            color: var(--text-muted);
        }

        .image-upload-area input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .post-input {
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            outline: none;
            resize: none;
            height: 44px;
            transition: border-color 0.2s;
            margin-bottom: 12px;
        }
        .post-input:focus { border-color: var(--primary-color); }

        .post-input-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .char-counter {
            font-size: 12px;
            color: var(--text-muted);
        }
        .char-counter.over { color: var(--error-color); }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-primary { background-color: var(--primary-color); color: white; width: 100%; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-primary:disabled { background-color: #b2dffc; cursor: not-allowed; }

        /* ===== POST CARD ===== */
        .post-card {
            background: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 24px;
            overflow: hidden;
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .post-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
        }

        .post-author {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .post-author-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #efefef;
            background-color: #efefef;
        }

        .post-author-name {
            font-size: 14px;
            font-weight: 600;
        }

        .post-menu {
            position: relative;
        }

        .post-menu-btn {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 4px 8px;
            color: var(--text-color);
            border-radius: 4px;
        }
        .post-menu-btn:hover { background: #f0f0f0; }

        .post-menu-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: var(--container-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-width: 150px;
            z-index: 50;
            overflow: hidden;
        }
        .post-menu-dropdown.show { display: block; }

        .post-menu-item {
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.15s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-family: 'Inter', sans-serif;
        }
        .post-menu-item:hover { background: #f8f8f8; }
        .post-menu-item.danger { color: var(--error-color); }

        .post-image-container {
            width: 100%;
            background: #000;
            display: flex;
            justify-content: center;
            max-height: 600px;
        }

        .post-image {
            max-width: 100%;
            max-height: 600px;
            object-fit: contain;
        }

        .post-actions {
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .like-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-color);
            transition: all 0.15s;
        }
        .like-btn:hover { transform: scale(1.05); }

        .like-btn .heart-icon {
            width: 24px;
            height: 24px;
            transition: all 0.2s;
        }

        .like-btn.liked .heart-icon { filter: none; }
        .like-btn.liked { color: var(--heart-color); }

        @keyframes heartBeat {
            0% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        .like-btn.animate .heart-icon {
            animation: heartBeat 0.35s ease-in-out;
        }

        .post-likes {
            padding: 0 16px 4px;
            font-size: 14px;
            font-weight: 600;
        }

        .post-caption {
            padding: 4px 16px 14px;
            font-size: 14px;
            line-height: 1.5;
        }

        .post-caption .caption-user {
            font-weight: 600;
            margin-right: 6px;
        }

        .post-time {
            padding: 0 16px 12px;
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        /* ===== EDIT MODAL ===== */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            z-index: 200;
            justify-content: center;
            align-items: center;
        }
        .modal-overlay.show { display: flex; }

        .modal-box {
            background: var(--container-bg);
            border-radius: 14px;
            padding: 24px;
            width: 90%;
            max-width: 440px;
            animation: fadeIn 0.25s ease-out;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            text-align: center;
        }

        .modal-input {
            width: 100%;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            outline: none;
            resize: none;
            height: 80px;
            margin-bottom: 16px;
        }
        .modal-input:focus { border-color: var(--primary-color); }

        .modal-actions {
            display: flex;
            gap: 10px;
        }

        .btn-secondary {
            background: none;
            border: 1px solid var(--border-color);
            color: var(--text-color);
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            flex: 1;
        }
        .btn-secondary:hover { background: #f8f8f8; }

        .btn-modal-primary {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            flex: 1;
        }
        .btn-modal-primary:hover { background: var(--primary-hover); }

        /* ===== ALERT ===== */
        .global-alert {
            display: none;
            position: fixed;
            top: calc(var(--header-height) + 10px);
            left: 50%;
            transform: translateX(-50%);
            z-index: 300;
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: white;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            animation: fadeIn 0.3s ease-out;
            max-width: 90%;
        }
        .global-alert.success { background: var(--success-color); }
        .global-alert.error { background: var(--error-color); }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }
        .empty-state-icon { font-size: 48px; margin-bottom: 16px; }
        .empty-state-text { font-size: 16px; font-weight: 500; }
        .empty-state-sub { font-size: 14px; margin-top: 6px; }

        /* ===== LOADING ===== */
        .loading-spinner {
            display: flex;
            justify-content: center;
            padding: 40px;
        }

        .spinner {
            width: 32px;
            height: 32px;
            border: 3px solid var(--border-color);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .layout { justify-content: center; }
            .main-feed { max-width: 100%; }
        }
    </style>
</head>
<body>

    <header>
        <div class="logo" onclick="window.location.href='/feed'">Instagram</div>
        <div class="header-nav">
            <a href="/feed" class="nav-link active" id="navFeed">Feed</a>
            <a href="/perfil" class="nav-link" id="navPerfil">Perfil</a>
            <a href="/admin" class="nav-link" id="navAdmin" style="display:none">Admin</a>
            <button class="logout-btn" onclick="logout()">Sair</button>
        </div>
    </header>

    <!-- GLOBAL ALERT -->
    <div class="global-alert" id="globalAlert"></div>

    <div class="layout">
        <!-- SIDEBAR — Lista de Usuários -->
        <aside class="sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">Usuários</div>
                <ul class="user-list" id="userList">
                    <li class="loading-spinner"><div class="spinner"></div></li>
                </ul>
            </div>
        </aside>

        <!-- MAIN FEED -->
        <main class="main-feed">
            <!-- Formulário de Novo Post -->
            <div class="new-post-card" id="newPostCard">
                <div class="new-post-header">
                    <img src="" alt="" class="user-avatar" id="myAvatar">
                    <span id="myUserName">Carregando...</span>
                </div>

                <div class="image-upload-area" id="imageUploadArea">
                    <div class="upload-icon">📷</div>
                    <div class="upload-text">Clique para selecionar uma imagem (JPG, JPEG ou PNG, máx. 10MB)</div>
                    <input type="file" id="imageInput" accept=".jpg,.jpeg,.png">
                </div>

                <textarea class="post-input" id="legendaInput" placeholder="Escreva uma legenda..." maxlength="200"></textarea>

                <div class="post-input-info">
                    <span class="char-counter" id="charCounter">0 / 200</span>
                    <span style="font-size:11px; color:var(--text-muted)">Apenas letras, números e espaços</span>
                </div>

                <button class="btn btn-primary" id="publishBtn" onclick="publicarPost()" disabled>Publicar</button>
            </div>

            <!-- Posts Feed -->
            <div id="feedContainer">
                <div class="loading-spinner"><div class="spinner"></div></div>
            </div>
        </main>
    </div>

    <!-- EDIT MODAL -->
    <div class="modal-overlay" id="editModal">
        <div class="modal-box">
            <div class="modal-title">Editar Legenda</div>
            <textarea class="modal-input" id="editLegendaInput" maxlength="200" placeholder="Nova legenda..."></textarea>
            <div class="post-input-info">
                <span class="char-counter" id="editCharCounter">0 / 200</span>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="fecharModal()">Cancelar</button>
                <button class="btn-modal-primary" id="editSaveBtn" onclick="salvarEdicao()">Salvar</button>
            </div>
        </div>
    </div>

    <script>
        // ===== GLOBAL STATE =====
        const token = localStorage.getItem('jwt_token');
        const userId = localStorage.getItem('user_id');
        const isAdmin = localStorage.getItem('user_is_admin') === '1';
        const apiBaseUrl = localStorage.getItem('api_base_url') || window.location.origin;

        if (!token || !userId) {
            window.location.href = '/login';
        }

        if (isAdmin) {
            document.getElementById('navAdmin').style.display = '';
        }

        const authHeaders = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        };

        let selectedUserId = null;
        let selectedImageBase64 = null;
        let editingPostId = null;
        let editingUserId = null;
        let allUsers = [];

        // ===== ALERTS =====
        function showAlert(msg, type = 'success') {
            const alert = document.getElementById('globalAlert');
            alert.textContent = msg;
            alert.className = `global-alert ${type}`;
            alert.style.display = 'block';
            setTimeout(() => { alert.style.display = 'none'; }, 4000);
        }

        // ===== USER AVATAR HELPER =====
        function getUserAvatar(user) {
            if (user.foto_url && user.foto_url.startsWith('data:image')) {
                return user.foto_url;
            }
            return `https://ui-avatars.com/api/?name=${encodeURIComponent(user.nome || 'U')}&background=efefef&color=262626&size=80`;
        }

        // ===== LOAD MY PROFILE =====
        async function carregarMeuPerfil() {
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${userId}`, { headers: authHeaders });
                const result = await res.json();
                if (res.ok && result.status === 'sucesso') {
                    const d = result.dados;
                    document.getElementById('myAvatar').src = getUserAvatar(d);
                    document.getElementById('myUserName').textContent = `@${d.usuario}`;
                } else if (res.status === 401) {
                    logout();
                }
            } catch (e) {}
        }

        // ===== LOAD USERS (Sidebar) =====
        async function carregarUsuarios() {
            const list = document.getElementById('userList');
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios`, { headers: authHeaders });
                const result = await res.json();
                if (res.ok && result.status === 'sucesso') {
                    allUsers = result.dados.usuarios;
                    renderUserList(allUsers);
                } else if (res.status === 401) {
                    logout();
                } else {
                    list.innerHTML = '<li style="padding:12px;color:var(--text-muted);font-size:13px">Nenhum usuário encontrado</li>';
                }
            } catch (e) {
                list.innerHTML = '<li style="padding:12px;color:var(--text-muted);font-size:13px">Erro ao carregar</li>';
            }
        }

        function renderUserList(users) {
            const list = document.getElementById('userList');
            list.innerHTML = '';

            // "Todos" option
            const allItem = document.createElement('li');
            allItem.className = `user-item ${selectedUserId === null ? 'active' : ''}`;
            allItem.innerHTML = `
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#f09433,#dc2743,#bc1888);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:14px">✦</div>
                <div class="user-item-info">
                    <div class="user-item-name">Todos os Posts</div>
                    <div class="user-item-username">feed completo</div>
                </div>`;
            allItem.onclick = () => { selectedUserId = null; carregarFeed(); renderUserList(users); };
            list.appendChild(allItem);

            users.forEach(u => {
                const li = document.createElement('li');
                li.className = `user-item ${selectedUserId === u.id ? 'active' : ''}`;
                const avatar = getUserAvatar(u);
                li.innerHTML = `
                    <img src="${avatar}" class="user-avatar" alt="${u.nome}">
                    <div class="user-item-info">
                        <div class="user-item-name">${u.nome}</div>
                        <div class="user-item-username">@${u.usuario}</div>
                    </div>`;
                li.onclick = () => { selectedUserId = u.id; carregarFeed(); renderUserList(users); };
                list.appendChild(li);
            });
        }

        // ===== IMAGE UPLOAD =====
        const imageInput = document.getElementById('imageInput');
        const uploadArea = document.getElementById('imageUploadArea');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validar formato (RNF07)
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                showAlert('Formato inválido! Apenas JPG, JPEG e PNG são aceitos.', 'error');
                imageInput.value = '';
                return;
            }

            // Validar tamanho (max 10MB - RNF07)
            if (file.size > 10 * 1024 * 1024) {
                showAlert('Imagem muito grande! Máximo 10MB.', 'error');
                imageInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(ev) {
                selectedImageBase64 = ev.target.result;
                uploadArea.classList.add('has-image');
                uploadArea.innerHTML = `<img src="${selectedImageBase64}" alt="Preview"><input type="file" id="imageInput" accept=".jpg,.jpeg,.png">`;
                // Re-attach listener
                document.getElementById('imageInput').addEventListener('change', arguments.callee.caller.bind(null, { target: document.getElementById('imageInput') }));
                atualizarBtnPublicar();
            };
            reader.readAsDataURL(file);
        });

        // ===== LEGENDA INPUT =====
        const legendaInput = document.getElementById('legendaInput');
        const charCounter = document.getElementById('charCounter');

        legendaInput.addEventListener('input', function() {
            const len = this.value.length;
            charCounter.textContent = `${len} / 200`;
            charCounter.classList.toggle('over', len > 200);
            atualizarBtnPublicar();
        });

        function atualizarBtnPublicar() {
            const btn = document.getElementById('publishBtn');
            const legenda = legendaInput.value;
            const legendaValida = /^[a-zA-Z0-9\s]*$/.test(legenda);
            btn.disabled = !(selectedImageBase64 && legenda.length <= 200 && legendaValida);
        }

        // ===== PUBLISH POST =====
        async function publicarPost() {
            const btn = document.getElementById('publishBtn');
            btn.disabled = true;
            btn.textContent = 'Publicando...';

            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${userId}/posts`, {
                    method: 'POST',
                    headers: authHeaders,
                    body: JSON.stringify({
                        imagem: selectedImageBase64,
                        legenda: legendaInput.value
                    })
                });
                const result = await res.json();

                if (res.ok && result.status === 'sucesso') {
                    showAlert('Post publicado com sucesso!');
                    // Reset form
                    selectedImageBase64 = null;
                    legendaInput.value = '';
                    charCounter.textContent = '0 / 200';
                    uploadArea.classList.remove('has-image');
                    uploadArea.innerHTML = `
                        <div class="upload-icon">📷</div>
                        <div class="upload-text">Clique para selecionar uma imagem (JPG, JPEG ou PNG, máx. 10MB)</div>
                        <input type="file" id="imageInput" accept=".jpg,.jpeg,.png">`;
                    document.getElementById('imageInput').addEventListener('change', handleImageChange);
                    carregarFeed();
                } else {
                    showAlert(result.mensagem || 'Erro ao publicar post', 'error');
                }
            } catch (e) {
                showAlert('Erro de conexão', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Publicar';
                atualizarBtnPublicar();
            }
        }

        function handleImageChange(e) {
            const file = e.target.files[0];
            if (!file) return;

            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                showAlert('Formato inválido! Apenas JPG, JPEG e PNG são aceitos.', 'error');
                return;
            }
            if (file.size > 10 * 1024 * 1024) {
                showAlert('Imagem muito grande! Máximo 10MB.', 'error');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(ev) {
                selectedImageBase64 = ev.target.result;
                uploadArea.classList.add('has-image');
                uploadArea.innerHTML = `<img src="${selectedImageBase64}" alt="Preview"><input type="file" id="imageInput" accept=".jpg,.jpeg,.png">`;
                document.getElementById('imageInput').addEventListener('change', handleImageChange);
                atualizarBtnPublicar();
            };
            reader.readAsDataURL(file);
        }

        // ===== LOAD FEED =====
        async function carregarFeed() {
            const container = document.getElementById('feedContainer');
            container.innerHTML = '<div class="loading-spinner"><div class="spinner"></div></div>';

            // Show/hide new post form depending on who we're viewing
            const newPostCard = document.getElementById('newPostCard');
            newPostCard.style.display = (selectedUserId === null || selectedUserId === userId) ? '' : 'none';

            try {
                let posts = [];

                if (selectedUserId) {
                    // Posts de um usuário específico
                    const res = await fetch(`${apiBaseUrl}/usuarios/${selectedUserId}/posts`, { headers: authHeaders });
                    const result = await res.json();
                    if (res.ok && result.status === 'sucesso') {
                        posts = result.posts.map(p => ({ ...p, user_id: selectedUserId }));
                    }
                } else {
                    // Feed de todos — buscar posts de cada usuário
                    const promises = allUsers.map(async (u) => {
                        try {
                            const res = await fetch(`${apiBaseUrl}/usuarios/${u.id}/posts`, { headers: authHeaders });
                            const result = await res.json();
                            if (res.ok && result.status === 'sucesso') {
                                return result.posts.map(p => ({ ...p, user_id: u.id, user_nome: u.nome, user_usuario: u.usuario, user_foto: u.foto_url }));
                            }
                        } catch (e) {}
                        return [];
                    });
                    const results = await Promise.all(promises);
                    posts = results.flat();
                    // Sort by criado_em descending
                    posts.sort((a, b) => new Date(b.criado_em) - new Date(a.criado_em));
                }

                if (posts.length === 0) {
                    container.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-state-icon">📸</div>
                            <div class="empty-state-text">Nenhuma postagem ainda</div>
                            <div class="empty-state-sub">Seja o primeiro a compartilhar uma foto!</div>
                        </div>`;
                    return;
                }

                container.innerHTML = '';
                posts.forEach(post => renderPost(post, container));

            } catch (e) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">⚠️</div>
                        <div class="empty-state-text">Erro ao carregar feed</div>
                        <div class="empty-state-sub">Tente novamente</div>
                    </div>`;
            }
        }

        // ===== RENDER POST =====
        function renderPost(post, container) {
            const postUserId = post.user_id;
            const isMine = String(postUserId) === String(userId);

            // Find user info
            let userName = post.user_usuario || '';
            let userNome = post.user_nome || '';
            let userFoto = post.user_foto || '';
            if (!userName && selectedUserId) {
                const u = allUsers.find(u => String(u.id) === String(selectedUserId));
                if (u) { userName = u.usuario; userNome = u.nome; userFoto = u.foto_url; }
            }

            const avatarSrc = (userFoto && userFoto.startsWith('data:image'))
                ? userFoto
                : `https://ui-avatars.com/api/?name=${encodeURIComponent(userNome || userName || 'U')}&background=efefef&color=262626&size=68`;

            const liked = post.curtiu;
            const likesCount = parseInt(post.curtidas) || 0;

            const card = document.createElement('div');
            card.className = 'post-card';
            card.dataset.postId = post.id;
            card.dataset.userId = postUserId;

            const timeAgo = formatTimeAgo(post.criado_em);

            card.innerHTML = `
                <div class="post-header">
                    <div class="post-author">
                        <img src="${avatarSrc}" class="post-author-avatar" alt="${userName}">
                        <span class="post-author-name">@${userName}</span>
                    </div>
                    ${isMine || isAdmin ? `
                    <div class="post-menu">
                        <button class="post-menu-btn" onclick="toggleMenu(this)">⋯</button>
                        <div class="post-menu-dropdown">
                            ${isMine ? `<button class="post-menu-item" onclick="abrirEdicao('${post.id}', '${postUserId}', '${escapeHtml(post.legenda)}')">✏️ Editar legenda</button>` : ''}
                            <button class="post-menu-item danger" onclick="deletarPost('${post.id}', '${postUserId}')">🗑️ Excluir post</button>
                        </div>
                    </div>` : ''}
                </div>
                <div class="post-image-container">
                    <img src="${post.imagem}" class="post-image" alt="Post de ${userName}">
                </div>
                <div class="post-actions">
                    <button class="like-btn ${liked ? 'liked' : ''}" onclick="curtirPost('${post.id}', '${postUserId}', this)">
                        <svg class="heart-icon" viewBox="0 0 24 24" fill="${liked ? 'var(--heart-color)' : 'none'}" stroke="${liked ? 'var(--heart-color)' : 'currentColor'}" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                        <span class="like-count">${likesCount}</span>
                    </button>
                </div>
                <div class="post-caption">
                    <span class="caption-user">@${userName}</span>${escapeHtml(post.legenda)}
                </div>
                <div class="post-time">${timeAgo}</div>`;

            container.appendChild(card);
        }

        // ===== LIKE/UNLIKE =====
        async function curtirPost(postId, postUserId, btn) {
            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${postUserId}/posts/${postId}`, {
                    method: 'POST',
                    headers: authHeaders
                });
                const result = await res.json();

                if (res.ok && result.status === 'sucesso') {
                    const acao = result.dados.acao;
                    const count = result.dados.curtidas;
                    const isLiked = acao === 'curtiu';

                    btn.classList.toggle('liked', isLiked);
                    btn.classList.add('animate');
                    setTimeout(() => btn.classList.remove('animate'), 400);

                    const svg = btn.querySelector('.heart-icon path');
                    btn.querySelector('svg').setAttribute('fill', isLiked ? 'var(--heart-color)' : 'none');
                    btn.querySelector('svg').setAttribute('stroke', isLiked ? 'var(--heart-color)' : 'currentColor');
                    btn.querySelector('.like-count').textContent = count;
                } else {
                    showAlert(result.mensagem || 'Erro ao curtir', 'error');
                }
            } catch (e) {
                showAlert('Erro de conexão', 'error');
            }
        }

        // ===== POST MENU =====
        function toggleMenu(btn) {
            const dropdown = btn.nextElementSibling;
            document.querySelectorAll('.post-menu-dropdown.show').forEach(d => {
                if (d !== dropdown) d.classList.remove('show');
            });
            dropdown.classList.toggle('show');
        }

        // Close menus on click outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.post-menu')) {
                document.querySelectorAll('.post-menu-dropdown.show').forEach(d => d.classList.remove('show'));
            }
        });

        // ===== EDIT POST =====
        function abrirEdicao(postId, userId, legenda) {
            editingPostId = postId;
            editingUserId = userId;
            document.getElementById('editLegendaInput').value = legenda;
            document.getElementById('editCharCounter').textContent = `${legenda.length} / 200`;
            document.getElementById('editModal').classList.add('show');
        }

        document.getElementById('editLegendaInput').addEventListener('input', function() {
            document.getElementById('editCharCounter').textContent = `${this.value.length} / 200`;
        });

        function fecharModal() {
            document.getElementById('editModal').classList.remove('show');
            editingPostId = null;
            editingUserId = null;
        }

        async function salvarEdicao() {
            const legenda = document.getElementById('editLegendaInput').value;
            const btn = document.getElementById('editSaveBtn');
            btn.disabled = true;
            btn.textContent = 'Salvando...';

            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${editingUserId}/posts/${editingPostId}`, {
                    method: 'PATCH',
                    headers: authHeaders,
                    body: JSON.stringify({ legenda })
                });
                const result = await res.json();

                if (res.ok && result.status === 'sucesso') {
                    showAlert('Legenda atualizada!');
                    fecharModal();
                    carregarFeed();
                } else {
                    showAlert(result.mensagem || 'Erro ao atualizar', 'error');
                }
            } catch (e) {
                showAlert('Erro de conexão', 'error');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Salvar';
            }
        }

        // ===== DELETE POST =====
        async function deletarPost(postId, postUserId) {
            if (!confirm('Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.')) return;

            try {
                const res = await fetch(`${apiBaseUrl}/usuarios/${postUserId}/posts/${postId}`, {
                    method: 'DELETE',
                    headers: authHeaders
                });
                const result = await res.json();

                if (res.ok) {
                    showAlert('Post excluído!');
                    carregarFeed();
                } else {
                    showAlert(result.mensagem || 'Erro ao excluir', 'error');
                }
            } catch (e) {
                showAlert('Erro de conexão', 'error');
            }
        }

        // ===== LOGOUT =====
        async function logout() {
            try {
                await fetch(`${apiBaseUrl}/usuarios/logout`, {
                    method: 'POST',
                    headers: authHeaders
                });
            } catch (e) {}
            localStorage.clear();
            window.location.href = '/login';
        }

        // ===== HELPERS =====
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatTimeAgo(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            const now = new Date();
            const diff = Math.floor((now - date) / 1000);

            if (diff < 60) return 'agora mesmo';
            if (diff < 3600) return `há ${Math.floor(diff / 60)} min`;
            if (diff < 86400) return `há ${Math.floor(diff / 3600)} h`;
            if (diff < 604800) return `há ${Math.floor(diff / 86400)} d`;
            return date.toLocaleDateString('pt-BR');
        }

        // ===== INIT =====
        document.addEventListener('DOMContentLoaded', async () => {
            await carregarMeuPerfil();
            await carregarUsuarios();
            await carregarFeed();
        });
    </script>
</body>
</html>
