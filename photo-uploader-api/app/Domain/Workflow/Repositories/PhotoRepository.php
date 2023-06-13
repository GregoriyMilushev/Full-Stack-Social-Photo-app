<?php

namespace App\Domain\Workflow\Repositories;

use App\Domain\Support\DTO\PhotoData;
use App\Domain\Support\Helpers\RepositoryArray;
use App\Domain\Support\Repositories\BaseRepository;
use App\Domain\Workflow\Models\Photo;
use Spatie\QueryBuilder\AllowedFilter;

class PhotoRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Photo::class;
    }

    public function allowedFilters()
    {
        return [
            AllowedFilter::exact('user.id'),
        ];
    }

    public function allowedSorts()
    {
        return [
            'created_at'
        ];
    }

    public function create(PhotoData $photoData)
    {
        return $this->model->newQuery()
            ->create([
                'filename'     => $photoData->getFilename(),
                'file_path'    => $photoData->getFilePath(),
                'description'  => $photoData->getDescription(),
                'user_id'      => $photoData->getUserId()
            ]);
    }
}
