<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    use HasFactory;

    public function centroAtencion()
    {
        return $this->belongsTo(CentroAtencion::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
