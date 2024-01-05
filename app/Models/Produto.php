<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;
    
    protected $table = 'produtos';
    protected $primaryKey = 'id';
    public $timestamps = false; // Se você não utilizar os campos 'created_at' e 'updated_at'

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($produto) {
            $user = Auth::user();
            if ($user) {
                $produto->user_create_id = $user->id;
            }
        });

        static::updating(function ($produto) {
            $user = Auth::user();
            if ($user) {
                $produto->user_update_id = $user->id;
            }
        });

        static::deleting(function ($produto) {
            $user = Auth::user();
            if ($user) {
                $produto->user_delete_id = $user->id;
                $produto->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Marca
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }

    // Relacionamento com Modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id');
    }

    // Relacionamento com Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Relacionamento com Fornecedor
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }

    // ... outros relacionamentos e métodos conforme necessário

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
