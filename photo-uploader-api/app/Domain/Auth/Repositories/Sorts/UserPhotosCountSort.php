<?php

namespace App\Domain\Auth\Repositories\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class UserPhotoCountSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        $query
            ->withCount('photos')
            ->orderBy('photos_count', $direction);
    }
}
