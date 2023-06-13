<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                          => $this->id,
            'message'                     => $this->message,
            'created_at'                  => $this->created_at,

            'sender'                      => $this->whenLoaded('user', $this->user ? [
                'id'   => $this->user->id,
                'full_name' => $this->user->full_name,
            ] : []),
            'photo'                       => $this->whenLoaded('photo', $this->photo ? [
                'id'   => $this->photo->id,
                'user_id'   => $this->photo->user_id,
            ] : [])
        ];
    }
}
