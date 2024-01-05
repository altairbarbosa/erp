<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cidade extends Model
{
    use SoftDeletes;
    use HasApiTokens;
    use SerializesModels;

    protected $table = 'cidades';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['nome', 'estado_id']; // Certifique-se de incluir outros campos conforme necessário
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cidade) {
            $user = Auth::user();
            if ($user) {
                $cidade->user_create_id = $user->id;
            }
        });

        static::updating(function ($cidade) {
            $user = Auth::user();
            if ($user) {
                $cidade->user_update_id = $user->id;
            }
        });

        static::deleting(function ($cidade) {
            $user = Auth::user();
            if ($user) {
                $cidade->user_delete_id = $user->id;
                $cidade->save(); // Salva o ID do usuário que deletou antes de realmente deletar
            }
        });
    }

    // Relacionamento com Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    // Método para obter Unidades relacionadas a essa cidade
    public function unidades()
    {
        return $this->hasMany(Unidade::class, 'cidade_id');
    }
}
