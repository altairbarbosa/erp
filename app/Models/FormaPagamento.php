<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormaPagamento extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;

    protected $table = 'formas_pagamentos';
    protected $primaryKey = 'id';
    public $timestamps = false; // Se você não utilizar os campos 'created_at' e 'updated_at'

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($formaPagamento) {
            $user = Auth::user();
            if ($user) {
                $formaPagamento->user_create_id = $user->id;
            }
        });

        static::updating(function ($formaPagamento) {
            $user = Auth::user();
            if ($user) {
                $formaPagamento->user_update_id = $user->id;
            }
        });

        static::deleting(function ($formaPagamento) {
            $user = Auth::user();
            if ($user) {
                $formaPagamento->user_delete_id = $user->id;
                $formaPagamento->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Negocio
    public function negocios()
    {
        return $this->hasMany(Negocio::class, 'forma_pagamento_id');
    }

    // Adicione os métodos acessores para os atributos que precisa para gerar strings
    // Deixe o Eloquent fazer a manipulação dos relacionamentos

    // Método acessor para obter clientes dos negócios como string
    public function getNegocioClienteToStringAttribute()
    {
        return $this->negocios->pluck('cliente_id')->implode(', ');
    }

    // Método acessor para obter status dos negócios como string
    public function getNegocioStatusToStringAttribute()
    {
        return $this->negocios->pluck('status_id')->implode(', ');
    }

    // Método acessor para obter unidades dos negócios como string
    public function getNegocioUnidadeToStringAttribute()
    {
        return $this->negocios->pluck('unidade_id')->implode(', ');
    }

    // Método acessor para obter formas de pagamento dos negócios como string
    public function getNegocioFormaPagamentoToStringAttribute()
    {
        return $this->negocios->pluck('forma_pagamento_id')->implode(', ');
    }

    // Defina os acessores para outros relacionamentos e atributos conforme necessário
}
