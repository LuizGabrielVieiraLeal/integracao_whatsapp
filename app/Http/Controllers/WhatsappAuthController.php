<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Whatsapp;

class WhatsappAuthController extends Controller
{
    // Gera o código e redireciona para o formulário de verificação
    public function gerarCodigo(Request $request)
    {
        $numero = $request->get('numero', '55119' . rand(100000, 999999)); // número de telefone do usuario
        session()->put('numero', $numero);

        Whatsapp::enviarCodigo($numero);

        return redirect()->route('form.verificacao');
    }

    public function reenviarCodigo()
    {
        $numero = session('numero');

        if (!$numero) {
            return back()->with('error', 'Número de telefone não encontrado na sessão. Faça a verificação novamente.');
        }

        try {
            Whatsapp::enviarCodigo($numero); // Certifique-se que este método exista
            return back()->with('status', 'Novo código enviado via WhatsApp! 📲');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao reenviar o código. Tente novamente.');
        }
    }

    // Exibe o formulário
    public function formVerificacao(Request $request)
    {
        return view('verificacao_whatsapp');
    }

    // Verifica o código enviado pelo usuário
    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        $numero = session('numero'); // número de telefone do usuario

        $valido = Whatsapp::verificarCodigo($numero, $request->input('codigo'));

        return back()->with('status', $valido ? 'Código válido! ✅' : 'Código inválido ou expirado ❌');
    }
}
