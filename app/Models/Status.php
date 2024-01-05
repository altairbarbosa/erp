<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($status) {
            $user = Auth::user();
            if ($user) {
                $status->user_create_id = $user->id;
            }
        });

        static::updating(function ($status) {
            $user = Auth::user();
            if ($user) {
                $status->user_update_id = $user->id;
            }
        });

        static::deleting(function ($status) {
            $user = Auth::user();
            if ($user) {
                $status->user_delete_id = $user->id;
                $status->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Produto
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'status_id');
    }

    // Relacionamento com Cliente
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'status_id');
    }

    // Relacionamento com Pedido
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'status_id');
    }

    // Método genérico para gerar strings a partir de IDs e relacionamentos
    private function generateStringFromIDs($relation)
    {
        return $this->$relation->pluck('nome')->implode(', ');
    }

    // Métodos específicos para obter strings de diferentes relacionamentos
    public function produtosToString()
    {
        return $this->generateStringFromIDs('produtos');
    }

    public function clientesToString()
    {
        return $this->generateStringFromIDs('clientes');
    }

    public function pedidosToString()
    {
        return $this->generateStringFromIDs('pedidos');
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
