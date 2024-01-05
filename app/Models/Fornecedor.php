<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $primaryKey = 'id';
    public $timestamps = false; // Se você não usar os campos 'created_at' e 'updated_at'

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fornecedor) {
            $user = Auth::user();
            if ($user) {
                $fornecedor->user_create_id = $user->id;
            }
        });

        static::updating(function ($fornecedor) {
            $user = Auth::user();
            if ($user) {
                $fornecedor->user_update_id = $user->id;
            }
        });

        static::deleting(function ($fornecedor) {
            $user = Auth::user();
            if ($user) {
                $fornecedor->user_delete_id = $user->id;
                $fornecedor->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Produto
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'fornecedor_id');
    }

    // Adicione os métodos acessores para os atributos que precisa para gerar strings
    // Deixe o Eloquent fazer a manipulação dos relacionamentos

    // Método acessor para obter marcas dos produtos como string
    public function getProdutoMarcaToStringAttribute()
    {
        return $this->produtos->pluck('marca_id')->implode(', ');
    }

    // Método acessor para obter modelos dos produtos como string
    public function getProdutoModeloToStringAttribute()
    {
        return $this->produtos->pluck('modelo_id')->implode(', ');
    }

    // Método acessor para obter empresas dos produtos como string
    public function getProdutoEmpresaToStringAttribute()
    {
        return $this->produtos->pluck('empresa_id')->implode(', ');
    }

    // Método acessor para obter status dos produtos como string
    public function getProdutoStatusToStringAttribute()
    {
        return $this->produtos->pluck('status_id')->implode(', ');
    }

    // Método acessor para obter fornecedores dos produtos como string
    public function getProdutoFornecedorToStringAttribute()
    {
        return $this->produtos->pluck('fornecedor_id')->implode(', ');
    }

    // Defina os acessores para outros relacionamentos e atributos conforme necessário
}
