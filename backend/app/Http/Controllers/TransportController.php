<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\TransportIndexRequest;
use App\Http\Resources\TransportResource;

class TransportController extends Controller
{
    public function index(TransportIndexRequest $request)
    {
        $params = $request->validated();

        $transports = \App\Models\Transport::query()
            ->when($params['search'] ?? null, fn($q, $search) => $q->where('number', 'like', "%{$search}%"))
            ->when($params['type'] ?? null, fn($q, $type) => $q->where('type', $type))
            ->orderByRaw('number::integer ASC')
            ->paginate(15);

        return TransportResource::collection($transports);
    }
}
