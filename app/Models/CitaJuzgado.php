<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CitaJuzgado extends Model
{
    use HasFactory;

    protected $table = 'citas_juzgados';

    public function juzgado()
    {
        return $this->belongsTo(Juzgado::class);
    }

    public function juez()
    {
        return $this->belongsTo(Juez::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
