<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $stops = $this->relationLoaded('stops') ? $this->stops : collect();

        return [
            'id' => $this->id,
            'number' => $this->number,
            'type' => $this->type,
            'name' => $this->name,

            // Используем фильтрацию через функцию
            'forward_stops' => StopResource::collection(
                $stops->filter(fn($stop) => $stop->pivot->is_backward === false)->values(),
            ),
            'backward_stops' => StopResource::collection(
                $stops->filter(fn($stop) => $stop->pivot->is_backward === true)->values(),
            ),
        ];
    }
}
