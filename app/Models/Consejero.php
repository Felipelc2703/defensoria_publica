<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consejero extends Model
{
    use HasFactory;

    public function dias()
    {
        return $this->hasMany(Dia::Class, 'consejero_id');
    }
}
