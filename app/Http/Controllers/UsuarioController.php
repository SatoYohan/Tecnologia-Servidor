<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    use ApiResponse;

    /**
     * GET /api/usuarios — Listar todos os usuários (somente ADM)
     */
    public function index()
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser || !$authUser->isAdmin()) {
            return $this->erro('ACESSO_NEGADO', 'Apenas administradores podem listar usuários', [], 403);
        }

        $usuarios = User::all()->map(function ($user) {
            return [
                'id' => (string) $user->id,
                'nome_completo' => $user->nome_completo,
                'usuario' => $user->usuario,
                'email' => $user->email,
                'biografia' => $user->biografia,
                'foto_url' => $user->foto_url,
                'is_admin' => $user->is_admin,
            ];
        });

        if ($usuarios->isEmpty()) {
            return $this->erro('NENHUM_USUARIO', 'Nenhum usuário encontrado', [], 404);
        }

        return $this->sucesso('LISTAGEM_SUCESSO', 'Usuários listados com sucesso', [
            'usuarios' => $usuarios,
        ], 200);
    }

    /**
     * POST /api/usuarios — Cadastrar novo usuário
     */
    public function store(StoreUsuarioRequest $request)
    {
        $dados = $request->validated();
        
        $user = User::create([
            'nome_completo' => $dados['nome_completo'],
            'usuario' => $dados['usuario'],
            'email' => $dados['email'],
            'senha' => $dados['senha'],
            'biografia' => $dados['biografia'] ?? null,
            'foto_url' => $dados['foto'] ?? null,
        ]);

        return $this->sucesso('USUARIO_CRIADO', 'Usuário cadastrado com sucesso', [
            'id' => (string) $user->id,
            'nome_completo' => $user->nome_completo,
            'usuario' => $user->usuario,
            'email' => $user->email,
            'biografia' => $user->biografia,
            'foto_url' => $user->foto_url,
        ], 201);
    }

    /**
     * GET /api/usuarios/{id} — Obter dados de um usuário
     * ADM: pode ver qualquer usuário
     * Comum: só pode ver seu próprio perfil
     */
    public function show($id)
    {
        $authUser = Auth::guard('api')->user();

        // Verifica permissão: se não é admin e está tentando ver outro perfil
        if (!$authUser->isAdmin() && (string) $authUser->id !== (string) $id) {
            return $this->erro('ACESSO_NEGADO', 'Você não tem permissão para visualizar este perfil', [], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->erro('USUARIO_NAO_ENCONTRADO', 'Usuário não encontrado', [], 404);
        }

        return $this->sucesso('USUARIO_ENCONTRADO', 'Dados do usuário recuperados', [
            'id' => (string) $user->id,
            'nome_completo' => $user->nome_completo,
            'usuario' => $user->usuario,
            'email' => $user->email,
            'biografia' => $user->biografia,
            'foto_url' => $user->foto_url,
            'is_admin' => $user->is_admin,
        ], 200);
    }

    /**
     * PATCH /api/usuarios/{id} — Atualizar usuário
     * ADM: pode atualizar qualquer usuário
     * Comum: só pode atualizar seu próprio perfil
     */
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $authUser = Auth::guard('api')->user();

        // Verifica permissão: se não é admin e está tentando editar outro perfil
        if (!$authUser->isAdmin() && (string) $authUser->id !== (string) $id) {
            return $this->erro('ACESSO_NEGADO', 'Você não tem permissão para editar este perfil', [], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->erro('USUARIO_NAO_ENCONTRADO', 'Usuário não existe', [], 404);
        }

        $dados = $request->validated();

        $updateData = [];

        if (isset($dados['nome_completo'])) {
            $updateData['nome_completo'] = $dados['nome_completo'];
        }
        if (isset($dados['usuario'])) {
            $updateData['usuario'] = $dados['usuario'];
        }
        if (isset($dados['email'])) {
            $updateData['email'] = $dados['email'];
        }
        if (array_key_exists('biografia', $dados)) {
            $updateData['biografia'] = $dados['biografia'] ?? $user->biografia;
        }
        if (array_key_exists('foto', $dados)) {
            $updateData['foto_url'] = $dados['foto'] ?? $user->foto_url;
        }
        if (!empty($dados['senha'])) {
            $updateData['senha'] = $dados['senha'];
        }

        $user->update($updateData);

        return $this->sucesso('USUARIO_ATUALIZADO', 'Usuário atualizado com sucesso', [
            'id' => (string) $user->id,
            'nome_completo' => $user->nome_completo,
            'usuario' => $user->usuario,
            'email' => $user->email,
            'biografia' => $user->biografia,
            'foto_url' => $user->foto_url,
        ], 200);
    }

    /**
     * DELETE /api/usuarios/{id} — Deletar usuário (soft delete)
     * ADM: pode deletar qualquer usuário
     * Comum: só pode deletar seu próprio perfil
     */
    public function destroy($id)
    {
        $authUser = Auth::guard('api')->user();

        // Verifica permissão: se não é admin e está tentando apagar outro perfil
        if (!$authUser->isAdmin() && (string) $authUser->id !== (string) $id) {
            return $this->erro('ACESSO_NEGADO', 'Você não tem permissão para excluir este perfil', [], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return $this->erro('USUARIO_NAO_ENCONTRADO', 'Usuário não existe', [], 404);
        }

        $user->delete(); // Soft delete

        return $this->sucesso('OPERACAO_SUCESSO', 'Usuário deletado com sucesso', [], 200);
    }
}
