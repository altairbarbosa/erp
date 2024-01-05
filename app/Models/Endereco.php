<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;
    
    protected $table = 'enderecos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($endereco) {
            $user = Auth::user();
            if ($user) {
                $endereco->user_create_id = $user->id;
            }
        });

        static::updating(function ($endereco) {
            $user = Auth::user();
            if ($user) {
                $endereco->user_update_id = $user->id;
            }
        });

        static::deleting(function ($endereco) {
            $user = Auth::user();
            if ($user) {
                $endereco->user_delete_id = $user->id;
                $endereco->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relacionamento com Cidade
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }

    // Relacionamento com Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
