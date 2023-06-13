<?php

namespace App\Domain\Support\Actions;

use App\Domain\Support\DTO\FileUploadData;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class UploadFileAction
{
    public function __invoke(FileUploadData $fileUploadData): string
    {
        $disk = Storage::disk('public');

        $fileName = Uuid::uuid4();
        $extension = $fileUploadData->getFile()->getClientOriginalExtension();

        $fullFileName = "{$fileName}.{$extension}";

        $storagePath = "photos/{$fullFileName}";

        $uploadedFilePath = $disk->putFileAs("", $fileUploadData->getFile(), $storagePath, ['visibility' => 'public']);

        if ($uploadedFilePath) {
            return $uploadedFilePath;
        }

        throw new \Exception('File could not be uploaded successfully. Please try again.');
    }
}
