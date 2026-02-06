<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,

            'order' => $this->whenPivotLoaded('stop_transport', fn() => $this->pivot->order),
            'is_backward_route' => $this->whenPivotLoaded('stop_transport', fn() => (bool) $this->pivot->is_backward),

            'transports' => TransportResource::collection($this->whenLoaded('transports')),
            'schedules' => ScheduleResource::collection($this->whenLoaded('schedules')),
        ];
    }
}
