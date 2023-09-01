<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juez extends Model
{
    use HasFactory;

    protected $table = 'jueces';

    public function juzgado()
    {
        return $this->belongsTo(Juzgado::class);
    }

    public function dias()
    {
        return $this->hasMany(Dia::Class, 'juez_id');
    }
}
