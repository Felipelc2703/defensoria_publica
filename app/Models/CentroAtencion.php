<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroAtencion extends Model
{
    use HasFactory;

    protected $table = 'centros_atencion';

    public function tramites()
    {
        return $this->belongsToMany(Tramite::class, 'tramite_centro', 'centro_atencion_id', 'tramite_id');
    }
}
