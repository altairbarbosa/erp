<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserAuditMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Adicione as colunas a serem preenchidas automaticamente
            $request->merge([
                'user_create_id' => $user->id,
                'user_update_id' => $user->id,
                'user_delete_id' => null, // ou defina uma lógica para definir quando for excluído
            ]);
        }

        return $next($request);
    }
}
