<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'token';
    /**
     * Transform the resource collection into an array.
     *
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'token'=>$this->accessToken->token,
            'expires_at'=>$this->accessToken->expires_at,
            'tokenable_id'=>$this->accessToken->tokenable_id
        ];
    }
}
