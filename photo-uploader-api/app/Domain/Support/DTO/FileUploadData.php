<?php

namespace App\Domain\Support\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadData extends DataTransferObject
{
    public UploadedFile $file;

    public static function fromRequest(Request $request)
    {
        return new static([
            'file' => $request->file('file'),
        ]);
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }
}
