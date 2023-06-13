<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadedFileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'preview_url'       => $this->preview_url,
            'original_filename' => $this->original_filename,
            'file_path'         => $this->file_path,
        ];
    }
}
