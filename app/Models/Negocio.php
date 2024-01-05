<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Negocio extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;
    
    protected $table = 'negocios';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($negocio) {
            $user = Auth::user();
            if ($user) {
                $negocio->user_create_id = $user->id;
            }
        });

        static::updating(function ($negocio) {
            $user = Auth::user();
            if ($user) {
                $negocio->user_update_id = $user->id;
            }
        });

        static::deleting(function ($negocio) {
            $user = Auth::user();
            if ($user) {
                $negocio->user_delete_id = $user->id;
                $negocio->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relacionamento com Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Relacionamento com Forma de Pagamento
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }

    // Relacionamento com Unidade
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    // Relacionamento com NegocioParcela
    public function negocioParcelas()
    {
        return $this->hasMany(NegocioParcela::class, 'negocio_id');
    }

    // Relacionamento com NegocioProduto
    public function negocioProdutos()
    {
        return $this->hasMany(NegocioProduto::class, 'negocio_id');
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
