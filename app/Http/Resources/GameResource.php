<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date_time'=> $this->date_time,
            'is_room_created'=> $this->is_room_created,
            'league' => new DescriptionResource($this->league),
            'team_1' => new DescriptionResource($this->team_1),
            'team_2' => new DescriptionResource($this->team_2)
        ];
    }
}
