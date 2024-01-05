<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Unidade extends Model
{
    protected $table = 'unidades';
    protected $primaryKey = 'id';
    public $timestamps = false; // Se você não usar os campos 'created_at' e 'updated_at'

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($unidade) {
            $user = Auth::user();
            if ($user) {
                $unidade->user_create_id = $user->id;
            }
        });

        static::updating(function ($unidade) {
            $user = Auth::user();
            if ($user) {
                $unidade->user_update_id = $user->id;
            }
        });

        static::deleting(function ($unidade) {
            $user = Auth::user();
            if ($user) {
                $unidade->user_delete_id = $user->id;
                $unidade->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Cidade
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    // Relacionamento com Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    // Relacionamento com Produto
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'empresa_id');
    }

    // Relacionamento com Negocio
    public function negocios()
    {
        return $this->hasMany(Negocio::class, 'unidade_id');
    }

    // Métodos acessores para obter strings de relacionamentos
    // ...

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
