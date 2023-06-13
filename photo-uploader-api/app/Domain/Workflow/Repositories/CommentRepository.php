<?php

namespace App\Domain\Messaging\Repositories;

use App\Domain\Support\Helpers\RepositoryArray;
use App\Domain\Support\Repositories\BaseRepository;
use App\Domain\Workflow\Models\Comment;

use Spatie\QueryBuilder\AllowedFilter;

class CommentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Comment::class;
    }

    public function allowedFilters()
    {
        return [
            AllowedFilter::exact('photo.id')
        ];
    }

    public function allowedSorts()
    {
        return ['created_at'];
    }

    public function create(array $commentData)
    {
        $commentData = $this->model->newQuery()->create(RepositoryArray::make($commentData, [
            'photo_id' => required(['photo.id', 'photo_id']),
            'user_id'  => required(['user.id', 'user_id']),
            'message'  => required('message'),
        ]));

        return $commentData;
    }

    public function update($commentId, array $commentData)
    {
        $this->model->find($commentId)
            ->update(RepositoryArray::make($commentData, [
                'message'   => omittable('message'),
            ]));

        return $this->get($commentId);
    }
}
