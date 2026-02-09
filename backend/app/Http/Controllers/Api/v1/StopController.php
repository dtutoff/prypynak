<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\StopIndexRequest;
use App\Http\Resources\StopResource;
use App\Models\Stop;


class StopController extends Controller
{
    public function index(StopIndexRequest $request)
    {
        $params = $request->validated();

        $stops = Stop::query()
            ->when($params->name, function ($query, $name) {
                $query->where('name', 'ilike', "%{$name}%");
            })
            ->orderBy('name')
            ->get();

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
                    ->with('transport')
                    ->orderBy('arrival_time')
                    ->limit(10);
            },
        ]);

        return new StopResource($stop);
    }
}
