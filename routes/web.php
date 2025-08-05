<?php

use App\Http\Controllers\WhatsappAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WhatsappAuthController::class, 'gerarCodigo'])->name('gerar.codigo');
Route::get('/reenviar-codigo', [WhatsappAuthController::class, 'reenviarCodigo'])->name('reenviar.codigo');
Route::get('/verificacao_whatsapp', [WhatsappAuthController::class, 'formVerificacao'])->name('form.verificacao');
Route::post('/verificacao_whatsapp', [WhatsappAuthController::class, 'verificarCodigo'])->name('verificar.codigo');
