<?php

namespace App\Domain\Support\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class BaseException extends HttpException implements HttpExceptionInterface
{
    public function __construct(string $message = '', int $statusCode, \Throwable $previous = null)
    {
        parent::__construct($statusCode, $message, $previous);
    }
}
