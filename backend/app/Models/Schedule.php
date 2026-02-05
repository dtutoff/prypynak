<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }

    public function stop()
    {
        return $this->belongsTo(Stop::class);
    }
}
