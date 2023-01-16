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
        return $this->belongsToMany(Requisito::class, 'requisito_tramite', 'tramite_id', 'requisito_id')->withPivot('obligatorio');
    }

    public function centrosAtencion()
    {
        return $this->belongsToMany(CentroAtencion::class, 'tramite_centro', 'tramite_id', 'centro_atencion_id');
    }
}
