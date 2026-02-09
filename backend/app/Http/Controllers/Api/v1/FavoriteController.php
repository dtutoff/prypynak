<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Stop;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    public function toggle(Stop $stop): JsonResponse
    {
        $user = auth()->user();

        $result = $user->favoriteStops()->toggle($stop->id);
        $isAttached = count($result['attached']) > 0;

        return response()->json([
            'message' => $isAttached
                ? 'Остановка добавлена в избранное.'
                : 'Остановка удалена из избранного',
            'is_favorite' => $isAttached,
        ]);
    }
}
