<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'status_id',
        'user_create_id',
        'user_update_id',
        'user_delete_id',
        'classificacao_id',
        'nome',
        'cpf',
        // Adicione outras colunas aqui, se necessário
    ];

    // Relacionamento com Classificacao
    public function classificacao()
    {
        return $this->belongsTo(Classificacao::class, 'classificacao_id');
    }

    // Relacionamento com Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    // Relacionamento com Negocios
    public function negocios()
    {
        return $this->hasMany(Negocio::class, 'cliente_id');
    }

    // Relacionamento com Telefones
    public function telefones()
    {
        return $this->hasMany(Telefone::class, 'cliente_id');
    }

    // Relacionamento com Enderecos
    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'cliente_id');
    }

    // Relacionamento com usuário que criou o cliente
    public function userCreated()
    {
        return $this->belongsTo(User::class, 'user_create_id');
    }

    // Relacionamento com usuário que atualizou o cliente
    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_update_id');
    }

    // Relacionamento com usuário que excluiu o cliente
    public function userDeleted()
    {
        return $this->belongsTo(User::class, 'user_delete_id');
    }
}
