<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTramite extends Model
{
    use HasFactory;

    public function requisitos()
    {
        return $this->hasMany(Requisito::class);
    }

    public function tramites()
    {
        return $this->hasMany(Tramite::class);
    }
}
