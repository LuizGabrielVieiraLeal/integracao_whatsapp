<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificacaoWhatsapp extends Model
{
    protected $table = 'verificacao_whatsapp';
    protected $fillable = ['numero', 'codigo', 'expires_at'];
    protected $dates = ['expires_at'];
}
