<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Api\v1\TransportIndexRequest;
use App\Http\Requests\Api\v1\TransportShowRequest;
use App\Http\Resources\TransportResource;
use App\Models\Transport;

class TransportController extends Controller
{
    public function index(TransportIndexRequest $request)
    {
        $params = $request->validated();

        $transports = Transport::query()
            ->when($params['search'] ?? null, fn($q, $search) => $q->where('number', 'like', "%{$search}%"))
            ->when($params['type'] ?? null, fn($q, $type) => $q->where('type', $type))
            ->orderByRaw('number::integer ASC')
            ->paginate(15);

        return TransportResource::collection($transports);
    }

    public function show(Transport $transport, TransportShowRequest $request)
    {
        $params = $request->validated();

        $direction = $params['direction'] ?? null;

        $stops = $transport
            ->stops()
            ->withPivot(['order', 'is_backward'])
            ->when($direction, function ($query) use ($direction) {
                $query->where('is_backward', $direction === 'backward');
            })
            ->get();

        $transport->setRelation('stops', $stops);

        $dayType = $params['day_type'] ?? (now()->isWeekend() ? 'weekend' : 'workday');
        $transport->load([
            'schedules' => function ($query) use ($params, $dayType) {
                $query
                    ->where('day_type', $dayType)
                    ->when(isset($params['direction']), function ($q) use ($params) {
                        $q->where('is_backward', $params['direction'] === 'backward');
                    })
                    ->orderBy('arrival_time');
            },
        ]);

        return new TransportResource($transport);
    }
}
