<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;

    protected $table = 'estados';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($estado) {
            $user = Auth::user();
            if ($user) {
                $estado->user_create_id = $user->id;
            }
        });

        static::updating(function ($estado) {
            $user = Auth::user();
            if ($user) {
                $estado->user_update_id = $user->id;
            }
        });

        static::deleting(function ($estado) {
            $user = Auth::user();
            if ($user) {
                $estado->user_delete_id = $user->id;
                $estado->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Unidades
    public function unidades()
    {
        return $this->hasMany(Unidade::class, 'estado_id');
    }

    // Relacionamento com Cidades
    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'estado_id');
    }

    // Métodos para conversão de dados em strings (se necessário)
    // ... (métodos para conversão de dados em strings, similar ao que você tem)

    // Exemplo de método adaptado para obter Unidades relacionadas a esse Estado
    public function getUnidades()
    {
        return $this->unidades;
    }

    // Exemplo de método adaptado para obter IDs de cidades relacionadas a esse Estado
    public function getUnidadeCidadeToString()
    {
        // Retorna os IDs das cidades relacionadas a esse Estado em uma string
        return $this->unidades->pluck('cidade_id')->implode(', ');
    }

    // Exemplo de método adaptado para obter IDs de estados relacionados a essa unidade
    public function getUnidadeEstadoToString()
    {
        // Retorna os IDs dos estados relacionados a essa unidade em uma string
        return $this->unidades->pluck('estado_id')->implode(', ');
    }

    // Exemplo de método adaptado para obter IDs de estados relacionados a essa cidade
    public function getCidadeEstadoToString()
    {
        // Retorna os IDs dos estados relacionados a essa cidade em uma string
        return $this->cidades->pluck('estado_id')->implode(', ');
    }
}
