<?php

namespace App\Exceptions;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class CustomValidationException extends RuntimeException implements HttpExceptionInterface
{
    /***
     * @var int
     */
    private int $statusCode;

    /**
     * @var array
     */
    private array $headers;

    /**
     * @param int $statusCode
     * @param string $message
     * @param Throwable|null $previous
     * @param array $headers
     * @param int|null $code
     */
    public function __construct(int $statusCode, string $message = 'The given data was invalid.', Throwable $previous = null, array $headers = [], ?int $code = 0)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
