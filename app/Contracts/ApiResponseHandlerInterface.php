<?php

namespace App\Contracts;

use App\Http\Data\Enum\DateErrorEnum;
use App\Http\Data\Enum\TokenErrorEnum;
use App\Http\Data\Enum\UserErrorEnum;

interface ApiResponseHandlerInterface
{
    public function handleJsonResponse($responseBody): void;
    public function getExceptionMessage(string $slug):TokenErrorEnum|UserErrorEnum|DateErrorEnum|string|null;

}
