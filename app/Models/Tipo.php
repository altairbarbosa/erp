<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tipo extends Model
{
    protected $table = 'tipos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tipo) {
            $user = Auth::user();
            if ($user) {
                $tipo->user_create_id = $user->id;
            }
        });

        static::updating(function ($tipo) {
            $user = Auth::user();
            if ($user) {
                $tipo->user_update_id = $user->id;
            }
        });

        static::deleting(function ($tipo) {
            $user = Auth::user();
            if ($user) {
                $tipo->user_delete_id = $user->id;
                $tipo->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Status
    public function status()
    {
        return $this->hasMany(Status::class, 'tipo_id');
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
