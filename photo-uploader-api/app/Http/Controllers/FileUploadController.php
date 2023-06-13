<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Http\Resources\UploadedFileResource;
use App\Domain\Support\Actions\UploadFileAction;
use App\Domain\Support\DTO\FileUploadData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * @group FileUpload
 */
class FileUploadController extends Controller
{
    /**
     * CREATE
     *
     * @bodyParam file blob required The file being uploaded
     *
     * @param UploadFileRequest $request
     * @param UploadFileAction $uploadFileAction
     * @return UploadedFileResource
     * @throws \Exception
     */
    public function store(UploadFileRequest $request, UploadFileAction $uploadFileAction)
    {
        $data = FileUploadData::fromRequest($request);
        $uploadedFilePath = $uploadFileAction($data);

        return new UploadedFileResource((object)[
            'preview_url'       => Storage::disk('public')->url($uploadedFilePath),
            'original_filename' => $request->file('file')->getClientOriginalName(),
            'file_path'         => $uploadedFilePath,
        ]);
    }
}
