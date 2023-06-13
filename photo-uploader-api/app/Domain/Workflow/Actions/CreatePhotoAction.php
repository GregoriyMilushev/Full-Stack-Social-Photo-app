<?php

namespace App\Domain\Workflow\Actions;

use App\Domain\Support\DTO\PhotoData;
use App\Domain\Workflow\Models\Photo;
use App\Domain\Workflow\Repositories\PhotoRepository;


class CreatePhotoAction
{
    /**
     * @var PhotoRepository
     */
    private PhotoRepository $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param PhotoData $photoData
     * @return Photo $photo
     */
    public function __invoke(PhotoData $photoData): Photo
    {
        $photo = $this->photoRepository->create($photoData);

        return $photo;
    }
}
