<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Traits;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\JsonResponse;

trait HandlesApiException
{
    public function handleException(\Throwable $e): JsonResponse
    {
        if ($e instanceof HttpException) {
            return $this->sendError(
                message: $e->getMessage(),
                code: $e->getStatusCode()
            );
        }

        return $this->sendError(
            message: $e->getMessage(),
            code: $e->getCode() ?: 500
        );
    }
}
