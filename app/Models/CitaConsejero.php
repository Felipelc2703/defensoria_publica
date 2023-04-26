<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaConsejero extends Model
{
    use HasFactory;

    protected $table = 'citas_consejeros';

    public function consejero()
    {
        return $this->belongsTo(Consejero::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
