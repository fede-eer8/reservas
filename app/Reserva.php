<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Sala;

class Reserva extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
