<?php

namespace App\Domain\Support\DTO;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class PaginationData extends DataTransferObject
{
    public int $page;
    public int $pageSize;

    public static function fromRequest(Request $request)
    {
        return new static([
            'page' => (int)$request->get('page') ?: 1,
            'pageSize' => (int)$request->get('pageSize') ?: 10
        ]);
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }
}