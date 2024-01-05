<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Telefone extends Model
{
    protected $table = 'telefones';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($telefone) {
            $user = Auth::user();
            if ($user) {
                $telefone->user_create_id = $user->id;
            }
        });

        static::updating(function ($telefone) {
            $user = Auth::user();
            if ($user) {
                $telefone->user_update_id = $user->id;
            }
        });

        static::deleting(function ($telefone) {
            $user = Auth::user();
            if ($user) {
                $telefone->user_delete_id = $user->id;
                $telefone->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
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
