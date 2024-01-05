<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NegocioProduto extends Model
{
    protected $table = 'negocios_produtos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($negocioProduto) {
            $user = Auth::user();
            if ($user) {
                $negocioProduto->user_create_id = $user->id;
            }
        });

        static::updating(function ($negocioProduto) {
            $user = Auth::user();
            if ($user) {
                $negocioProduto->user_update_id = $user->id;
            }
        });

        static::deleting(function ($negocioProduto) {
            $user = Auth::user();
            if ($user) {
                $negocioProduto->user_delete_id = $user->id;
                $negocioProduto->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    // Relacionamento com Negocio
    public function negocio()
    {
        return $this->belongsTo(Negocio::class, 'negocio_id');
    }

    // Métodos para registros de usuário em operações
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }

    public function userDeleted()
    {
        return $this->belongsTo(User::class, 'user_delete_id');
    }
}
