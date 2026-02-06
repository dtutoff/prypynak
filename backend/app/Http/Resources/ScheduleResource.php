<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'arrival_time' => $this->arrival_time,
            'day_type' => $this->day_type,
            'is_backward' => (bool) $this->is_backward,

            'transport_id' => $this->transport_id,

            'transport_number' => $this->whenLoaded('transport', fn() => $this->transport->number),
        ];
    }
}
