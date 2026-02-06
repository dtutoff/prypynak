<?php

namespace App\Http\Controllers;

use App\Http\Resources\StopResource;
use App\Models\Stop;

class StopController extends Controller
{
    public function index()
    {
        $stops = Stop::orderBy('name')->get();
        return StopResource::collection($stops);
    }

    public function show(Stop $stop)
    {
        $dayType = now()->isWeekend() ? 'weekend' : 'workday';
        $currentTime = now()->format('H:i:s');

        $stop->load([
            'transports' => function ($query) {
                $query->distinct();
            },
            'schedules' => function ($query) use ($dayType, $currentTime) {
                $query
                    ->where('day_type', $dayType)
                    ->where('arrival_time', '>=', $currentTime)
                    ->with('transport') // Чтобы ресурс знал номер автобуса
                    ->orderBy('arrival_time')
                    ->limit(10);
            },
        ]);

        return new StopResource($stop);
    }
}
