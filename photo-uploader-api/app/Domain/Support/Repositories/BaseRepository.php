<?php

namespace App\Domain\Support\Repositories;

use App\Domain\Support\DTO\PaginationData;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseRepository
{
    /** @var Model */
    protected $model;

    public abstract function model(): string;

    public function allowedFilters()
    {
        return [];
    }

    public function allowedSorts()
    {
        return [];
    }

    public function __construct()
    {
        $this->model = app($this->model());
    }

    public function withTrashed()
    {
        $this->model = app($this->model())->withTrashed();

        return $this;
    }

    public function withoutGlobalScopes($array = [])
    {
        foreach ($array as $scope) {
            $this->model->withoutGlobalScope($scope);
        }

        return $this;
    }

    /**
     * @param null $callbackBefore
     * @param null $callbackAfter
     * @return QueryBuilder
     */
    public function viaSpatieQueryBuilder($callbackBefore = null, $callbackAfter = null)
    {
        $query = QueryBuilder::for($this->model->newQuery());

        if ($callbackBefore) {
            $callbackBefore($query);
        }

        $query
            ->allowedFilters($this->allowedFilters())
            ->allowedSorts($this->allowedSorts());

        if ($callbackAfter) {
            $callbackAfter($query);
        }

        return $query;
    }

    /**
     * @param array $with
     * @param PaginationData|null $paginationData
     * @param null $callbackBeforeSpatie
     * @param null $callbackAfterSpatie
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection|QueryBuilder[]
     */
    public function all($with = [], PaginationData $paginationData = null, $callbackBeforeSpatie = null, $callbackAfterSpatie = null, $select = ['*'])
    {
        $query = $this->viaSpatieQueryBuilder($callbackBeforeSpatie, $callbackAfterSpatie)
            ->with($with);

        if ($paginationData) {
            return $query
                ->paginate($paginationData->getPageSize(), $select, 'page', $paginationData->getPage());
        }

        return $query->get();
    }

    public function get($id, $with = [])
    {
        return $this->model->newQuery()
            ->whereId($id)
            ->with($with)
            ->first();
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }
}
