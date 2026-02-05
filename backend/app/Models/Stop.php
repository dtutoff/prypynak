<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    public function transports()
    {
        return $this->belongsToMany(Transport::class, 'stop_transport');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
