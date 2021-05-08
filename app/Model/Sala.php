<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Model\Reserva;

class Sala extends Model
{
    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
