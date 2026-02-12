<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\StopIndexRequest;
use App\Http\Resources\StopResource;
use App\Models\Stop;


class StopController extends Controller
{
    public function index(StopIndexRequest $request)
    {
        $stops = Stop::query()
            ->when($request->validated('name'), function ($query, $name) {
                $query->where('name', 'ilike', "%{$name}%");
            })
            ->orderBy('name')
            ->paginate(10);

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
