<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;;

class Classificacao extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;

    protected $table = 'classificacoes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['nome',]; // Certifique-se de incluir outros campos conforme necessário

    // Relacionamento com Clientes
    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'classificacao_id');
    }

    // Método para obter status relacionados a essa classificação
    public function statusRelacionados()
    {
        return Status::whereIn('id', $this->clientes()->pluck('status_id'))->get();
    }

    // Métodos para conversão de dados em strings (se necessário)
    // ... (métodos para conversão de dados em strings, similar ao que você tem)

    // Exemplo de método adaptado para obter clientes relacionados a essa classificação
    public function getClientes()
    {
        return Cliente::where('classificacao_id', $this->id)->get();
    }

    // Exemplo de método adaptado para obter status relacionados a essa classificação
    public function getClienteStatusToString()
    {
        // Retorna os IDs dos status relacionados a essa classificação em uma string
        return $this->statusRelacionados()->implode('id', ', ');
    }

    // Exemplo de método adaptado para obter classificações relacionadas a essa classificação
    public function getClienteClassificacaoToString()
    {
        // Retorna os IDs das classificações relacionadas a essa classificação em uma string
        return $this->clientes()->pluck('classificacao_id')->implode(', ');
    }
}
