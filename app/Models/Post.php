<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'imagem',
        'legenda',
    ];

    /**
     * Relacionamento: Post pertence a um User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: Post tem muitas Curtidas.
     */
    public function curtidas()
    {
        return $this->hasMany(Curtida::class);
    }

    /**
     * Retorna a quantidade total de curtidas do post.
     */
    public function totalCurtidas(): int
    {
        return $this->curtidas()->count();
    }

    /**
     * Verifica se um usuário específico curtiu este post.
     */
    public function curtiuPor(int $userId): bool
    {
        return $this->curtidas()->where('user_id', $userId)->exists();
    }
}
