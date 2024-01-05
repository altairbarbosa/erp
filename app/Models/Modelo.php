<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Modelo extends Model
{
    protected $table = 'modelos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($modelo) {
            $user = Auth::user();
            if ($user) {
                $modelo->user_create_id = $user->id;
            }
        });

        static::updating(function ($modelo) {
            $user = Auth::user();
            if ($user) {
                $modelo->user_update_id = $user->id;
            }
        });

        static::deleting(function ($modelo) {
            $user = Auth::user();
            if ($user) {
                $modelo->user_delete_id = $user->id;
                $modelo->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Produto
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'modelo_id');
    }

    // Métodos set e get para retornar string de IDs relacionados para diferentes entidades
    // ...

    // Defina os métodos set e get conforme necessário para retornar as strings de IDs relacionados
}
