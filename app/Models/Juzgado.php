<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juzgado extends Model
{
    use HasFactory;

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function jueces()
    {
        return $this->hasMany(Juez::class);
    }
}
