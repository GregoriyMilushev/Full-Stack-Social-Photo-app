<?php

namespace App\Domain\Support\Exceptions;


use Illuminate\Http\Response;
use Throwable;

class RepositoryValidationException extends BaseException
{
    public $fieldErrorPairs = [];

    public function __construct($fieldErrorPairs, $code = 0, Throwable $previous = null)
    {
        $this->fieldErrorPairs = $fieldErrorPairs;

        parent::__construct('The given data was invalid.', Response::HTTP_UNPROCESSABLE_ENTITY, $previous);
    }
}
