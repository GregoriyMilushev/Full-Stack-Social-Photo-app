<?php

namespace App\Domain\Support\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

abstract class PhotoData extends DataTransferObject
{
    public ?string $description;
    public string $filename;
    public string $file_path;

    public static function fromRequest(Request $request)
    {
        return new static($request->all());
    }

    public function getUserId()
    {
        $authUser = auth()->user();
        return $authUser ? $authUser->id : null;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getFilePath()
    {
        return $this->file_path;
    }
}
