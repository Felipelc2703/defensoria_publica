<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function centroAtencion()
    {
        return $this->belongsTo(CentroAtencion::class);
    }
}
