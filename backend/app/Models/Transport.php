<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    public function stops()
    {
        return $this
            ->belongsToMany(Stop::class, 'stop_transport')
            ->withPivot(['order', 'is_backward'])
            ->orderBy('pivot_order');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
