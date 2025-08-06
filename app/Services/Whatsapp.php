<?php

namespace App\Services;

use App\Models\VerificacaoWhatsapp;
use Illuminate\Support\Carbon;

class Whatsapp
{

    /**
     * Gera um código de 6 dígitos, salva no banco e envia via WhatsApp.
     */
    public static function enviarCodigo(string $numero): string
    {
        $codigo = (string) rand(100000, 999999); // Código numérico de 6 dígitos

        $vw = VerificacaoWhatsapp::create([
            'numero'     => $numero,
            'codigo'     => $codigo,
            'expires_at' => now()->addMinutes(10),
        ]);

        $mensagem = "Seu código de verificação é: $vw->codigo";
        self::enviarWhatsapp($vw->numero, $mensagem);

        return $vw->codigo;
    }

    /**
     * Verifica se o código informado é o último válido para o número.
     */
    public static function verificarCodigo(string $numero, string $codigoInformado): bool
    {
        $registro = VerificacaoWhatsapp::where('numero', $numero)
            ->orderByDesc('created_at')
            ->first();

        if (!$registro) return false;

        $valido = $registro->codigo === $codigoInformado
            && Carbon::parse($registro->expires_at)->isFuture();

        if ($valido) {
            $registro->verificado = true;
            $registro->save();
        }

        return $valido;
    }

    /**
     * Envia a mensagem para o Whatsapp do cliente.
     */
    private static function enviarWhatsapp(string $numero, string $mensagem): void
    {
        /*
        Http::withToken('SEU_TOKEN')
            ->post('https://graph.facebook.com/v23.0/SEU_PHONE_ID/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $numero,
                'type' => 'text',
                'text' => ['body' => $mensagem],
            ]);
        */
    }
}
