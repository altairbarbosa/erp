<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;

    protected $table = 'marcas';
    protected $primaryKey = 'id';
    public $timestamps = false; // Se você não usar os campos 'created_at' e 'updated_at'

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($marca) {
            $user = Auth::user();
            if ($user) {
                $marca->user_create_id = $user->id;
            }
        });

        static::updating(function ($marca) {
            $user = Auth::user();
            if ($user) {
                $marca->user_update_id = $user->id;
            }
        });

        static::deleting(function ($marca) {
            $user = Auth::user();
            if ($user) {
                $marca->user_delete_id = $user->id;
                $marca->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Produto
    public function produtos()
    {
        return $this->hasMany(Produto::class, 'marca_id');
    }

    // Adicione os métodos acessores para os atributos que precisa para gerar strings
    // Deixe o Eloquent fazer a manipulação dos relacionamentos

    // Método acessor para obter produtos como string
    public function getProdutoMarcaToStringAttribute()
    {
        return $this->produtos->pluck('id')->implode(', ');
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

    // Métodos similares para outros relacionamentos podem ser adicionados da mesma forma

    // Defina os acessores para outros relacionamentos e atributos conforme necessário
}
