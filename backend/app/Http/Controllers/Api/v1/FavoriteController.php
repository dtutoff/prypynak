<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\StopResource;
use App\Models\Stop;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = auth()->user()->favoriteStops()->with('transports')->get();

        return StopResource::collection($favorites);
    }

    public function toggle(Stop $stop): JsonResponse
    {
        $user = auth()->user();

        $result = auth()->user()->favoriteStops()->toggle($stop->id);
        $isAttached = count($result['attached']) > 0;

        return response()->json([
            'message' => $isAttached
                ? 'Остановка добавлена в избранное.'
                : 'Остановка удалена из избранного.',
            'is_favorite' => $isAttached,
        ]);
    }
}
