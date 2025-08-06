<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VerificacaoWhatsapp;

class NumeroVerificado
{
    public function handle(Request $request, Closure $next)
    {
        $numero = session('numero');

        if (!$numero) {
            return redirect()->route('verificacao.inicio')->with('error', 'Número não encontrado na sessão.');
        }

        $registro = VerificacaoWhatsapp::where('numero', $numero)
            ->orderByDesc('created_at')
            ->first();

        if (!$registro || !$registro->verificado) {
            return redirect()->route('verificacao.inicio')->with('error', 'Você precisa verificar seu número antes de continuar.');
        }

        return $next($request);
    }
}
