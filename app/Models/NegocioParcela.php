<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NegocioParcela extends Model
{
    protected $table = 'negocios_parcelas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($negocioParcela) {
            $user = Auth::user();
            if ($user) {
                $negocioParcela->user_create_id = $user->id;
            }
        });

        static::updating(function ($negocioParcela) {
            $user = Auth::user();
            if ($user) {
                $negocioParcela->user_update_id = $user->id;
            }
        });

        static::deleting(function ($negocioParcela) {
            $user = Auth::user();
            if ($user) {
                $negocioParcela->user_delete_id = $user->id;
                $negocioParcela->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Negocio
    public function negocio()
    {
        return $this->belongsTo(Negocio::class, 'negocio_id');
    }

    // Relacionamento com Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
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
