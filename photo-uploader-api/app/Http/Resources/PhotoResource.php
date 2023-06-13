<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'filename'     => $this->filename,
            'file_path'    => $this->file_path,
            'preview_url'  => $this->preview_url,
            'created_at'   => $this->created_at,
            
            'uploaded_by'  => new UserResource($this->whenLoaded('uploadedBy')),
        ];
    }
}
