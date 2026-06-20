<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\Curtida;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    use ApiResponse;

    /**
     * GET /usuarios/{id_usuario}/posts — Listar todos os posts de um usuário
     * Critérios: 7 (leitor vê postagens), 13 (servidor envia postagem do autor), 17 (servidor envia postagens pedidas)
     */
    public function index($id_usuario)
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser) {
            return $this->erro('ACESSO_NEGADO', 'Token inválido ou expirado', [], 401);
        }

        $usuario = User::find($id_usuario);

        if (!$usuario) {
            return $this->erro('USUARIO_NAO_ENCONTRADO', 'Usuário não encontrado', [], 404);
        }

        $posts = $usuario->posts()->orderBy('created_at', 'desc')->get();

        if ($posts->isEmpty()) {
            return $this->erro('NENHUM_POST', 'Nenhum post encontrado', [], 404);
        }

        $postsFormatados = $posts->map(function ($post) use ($authUser) {
            return [
                'id' => (string) $post->id,
                'legenda' => $post->legenda,
                'imagem' => $post->imagem,
                'curtidas' => (string) $post->totalCurtidas(),
                'curtiu' => $post->curtiuPor($authUser->id),
                'criado_em' => $post->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'status' => 'sucesso',
            'codigo' => 'LISTAGEM_POSTS_SUCESSO',
            'mensagem' => 'Posts listados com sucesso',
            'posts' => $postsFormatados,
        ], 200);
    }

    /**
     * POST /usuarios/{id_usuario}/posts — Criar um novo post
     * Critérios: 2 (autor envia postagem), 12 (servidor recebe e publica postagem)
     */
    public function store(StorePostRequest $request, $id_usuario)
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser) {
            return $this->erro('ACESSO_NEGADO', 'Token inválido ou expirado', [], 401);
        }

        // Verificar se o usuário existe
        $usuario = User::find($id_usuario);
        if (!$usuario) {
            return $this->erro('USUARIO_NAO_ENCONTRADO', 'Usuário não encontrado', [], 404);
        }

        // Somente o próprio usuário pode criar posts em seu perfil
        if ((string) $authUser->id !== (string) $id_usuario) {
            return $this->erro('ACESSO_NEGADO', 'Você só pode criar posts no seu próprio perfil', [], 403);
        }

        $dados = $request->validated();

        $post = Post::create([
            'user_id' => $authUser->id,
            'imagem' => $dados['imagem'],
            'legenda' => $dados['legenda'],
        ]);

        return $this->sucesso('OPERACAO_SUCESSO', 'Post criado com sucesso', [
            'id' => (string) $post->id,
            'legenda' => $post->legenda,
            'curtidas' => '0',
        ], 201);
    }

    /**
     * GET /usuarios/{id_usuario}/posts/{id_post} — Detalhar um post específico
     * Critérios: 3 (autor lê sua postagem), 13 (servidor envia a postagem do autor)
     */
    public function show($id_usuario, $id_post)
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser) {
            return $this->erro('ACESSO_NEGADO', 'Token inválido ou expirado', [], 401);
        }

        $usuario = User::find($id_usuario);
        if (!$usuario) {
            return $this->erro('USUARIO_NAO_ENCONTRADO', 'Usuário não encontrado', [], 404);
        }

        $post = Post::where('id', $id_post)->where('user_id', $id_usuario)->first();

        if (!$post) {
            return $this->erro('POST_NAO_ENCONTRADO', 'Post não encontrado', [], 404);
        }

        return response()->json([
            'status' => 'sucesso',
            'codigo' => 'POST_ENCONTRADO',
            'mensagem' => 'Post recuperado com sucesso',
            'legenda' => $post->legenda,
            'imagem' => $post->imagem,
            'curtidas' => (string) $post->totalCurtidas(),
            'curtiu' => $post->curtiuPor($authUser->id),
            'criado_em' => $post->created_at->toIso8601String(),
        ], 200);
    }

    /**
     * POST /usuarios/{id_usuario}/posts/{id_post} — Curtir/Descurtir post (toggle)
     * Critérios: 8 (leitor curte), 9 (leitor descurte), 18/19 (servidor recebe pedido)
     * RNF12: curtir/descurtir apenas 1 vez
     * RNF14: não permitir curtida sem autenticação
     */
    public function curtir($id_usuario, $id_post)
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser) {
            return $this->erro('ACESSO_NEGADO', 'Token inválido ou expirado', [], 401);
        }

        $post = Post::where('id', $id_post)->where('user_id', $id_usuario)->first();

        if (!$post) {
            return $this->erro('POST_NAO_ENCONTRADO', 'Post não encontrado', [], 404);
        }

        // Toggle: se já curtiu, descurte. Se não curtiu, curte.
        $curtidaExistente = Curtida::where('user_id', $authUser->id)
            ->where('post_id', $post->id)
            ->first();

        if ($curtidaExistente) {
            // Descurtir
            $curtidaExistente->delete();
            return $this->sucesso('OPERACAO_SUCESSO', 'Curtida removida com sucesso', [
                'acao' => 'descurtiu',
                'curtidas' => (string) $post->totalCurtidas(),
            ], 200);
        } else {
            // Curtir
            Curtida::create([
                'user_id' => $authUser->id,
                'post_id' => $post->id,
            ]);
            return $this->sucesso('OPERACAO_SUCESSO', 'Curtida adicionada com sucesso', [
                'acao' => 'curtiu',
                'curtidas' => (string) $post->totalCurtidas(),
            ], 201);
        }
    }

    /**
     * PATCH /usuarios/{id_usuario}/posts/{id_post} — Atualizar legenda do post
     * Critérios: 4 (autor atualiza postagem), 14 (servidor recebe atualização)
     * RNF08: só pode editar a legenda
     */
    public function update(UpdatePostRequest $request, $id_usuario, $id_post)
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser) {
            return $this->erro('ACESSO_NEGADO', 'Token inválido ou expirado', [], 401);
        }

        $post = Post::where('id', $id_post)->where('user_id', $id_usuario)->first();

        if (!$post) {
            return $this->erro('POST_NAO_ENCONTRADO', 'Post não encontrado', [], 404);
        }

        // Somente o autor pode editar seu post
        if ((string) $authUser->id !== (string) $post->user_id) {
            return $this->erro('ACESSO_NEGADO', 'Você só pode editar seus próprios posts', [], 403);
        }

        $dados = $request->validated();
        $post->update(['legenda' => $dados['legenda']]);

        return $this->sucesso('OPERACAO_SUCESSO', 'Post atualizado com sucesso', [
            'id' => (string) $post->id,
            'legenda' => $post->legenda,
        ], 200);
    }

    /**
     * DELETE /usuarios/{id_usuario}/posts/{id_post} — Deletar post
     * Critérios: 5 (autor apaga postagem), 15 (servidor apaga a pedido do autor)
     * RNF09: deleta o post inteiro (não é possível remover só foto ou legenda)
     */
    public function destroy($id_usuario, $id_post)
    {
        $authUser = Auth::guard('api')->user();

        if (!$authUser) {
            return $this->erro('ACESSO_NEGADO', 'Token inválido ou expirado', [], 401);
        }

        $post = Post::where('id', $id_post)->where('user_id', $id_usuario)->first();

        if (!$post) {
            return $this->erro('POST_NAO_ENCONTRADO', 'Post não encontrado', [], 404);
        }

        // Somente o autor ou admin pode deletar
        if (!$authUser->isAdmin() && (string) $authUser->id !== (string) $post->user_id) {
            return $this->erro('ACESSO_NEGADO', 'Você não tem permissão para deletar este post', [], 403);
        }

        $post->delete(); // As curtidas serão deletadas automaticamente pelo onDelete('cascade')

        return $this->sucesso('OPERACAO_SUCESSO', 'Post deletado com sucesso', [], 200);
    }
}
