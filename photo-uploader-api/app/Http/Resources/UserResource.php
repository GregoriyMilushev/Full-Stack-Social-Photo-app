<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
            return [
                'id'                 => $this->id,
                'first_name'         => $this->first_name,
                'last_name'          => $this->last_name,
                'full_name'          => "$this->first_name $this->last_name",
                'email'              => $this->email,
                // 'avatar'             => $this->avatar,
                'role'               => $this->whenLoaded('role', $this->role->name),
            ];
    }
}
