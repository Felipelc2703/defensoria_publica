<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;

    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class);
    }

    public function requisitos()
    {
        return $this->belongsToMany(Requisito::class, 'requisito_tramite', 'tramite_id', 'requisito_id');
    }
}
