<?php

namespace App\Http\Controllers;

use App\Domain\Support\DTO\PaginationData;
use App\Http\Requests\PhotoCreateRequest;
use App\Http\Resources\PhotoResource;
use App\Domain\Support\DTO\PhotoData;
use App\Domain\Workflow\Actions\CreatePhotoAction;
use App\Domain\Workflow\Repositories\PhotoRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PhotoController extends Controller
{
    private PhotoRepository $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * LIST
     *
     * @queryParam user.id string Find Photos with exact match on [Photo.user.id]
     * @queryParam sort string Sort Photo by a column. Allowed columns [created_at]. For asc order, use sort=-created_at (note the minus sign)
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return PhotoResource::collection(
            $this->photoRepository->all(['uploadedBy'], PaginationData::fromRequest($request))
        );
    }

    /**
     * CREATE
     *
     * @bodyParam filename string required
     * @bodyParam file_path string required
     * @bodyParam descriptio string omitable
     *
     * @param PhotoCreateRequest $request
     * @param CreatePhotoAction $createPhotoAction
     * @return PhotoResource
     */
    public function store(PhotoCreateRequest $request, CreatePhotoAction $createPhotoAction)
    {
        $photo = $createPhotoAction(PhotoData::fromRequest($request));

        $photo->load([
            'uploadedBy'
        ]);

        return new PhotoResource($photo);
    }

    /**
     * GET
     *
     * @param Request $request
     * @param $id
     */
    public function show(Request $request, $id)
    {
        $fileRecord = $this->photoRepository->get($id);
        
        if(!$fileRecord) {
            return response(null, 404);
        }
        return Storage::disk('public')->download($fileRecord->file_path, $fileRecord->filename);
    }

    /**
     * DELETE
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        return $this->photoRepository->delete($id);
    }
}
