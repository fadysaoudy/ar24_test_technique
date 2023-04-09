<?php

namespace App\Contracts;

use App\Http\Data\Enum\DateErrorEnum;
use App\Http\Data\Enum\TokenErrorEnum;
use App\Http\Data\Enum\UserErrorEnum;
use App\Http\Requests\DTO\User\UserGetRequest;
use Exception;

interface HttpWrapperInterface
{
    public function setBaseUrl(string $baseUrl): void;

    public function setToken(string $token): void;

    public function setSecret(string $api_secret): void;

    public function setVerify(bool $verify): void;

    public function setTimeout(int $timeout): void;

    public function getBaseUrl(): string;

    public function getVerify(): bool;

    public function getTimeout(): int;

    /**
     * @throws Exception
     */
    public function get(string $endpoint, UserGetRequest $data, array $headers);


    public static function makeSignature(string $date): bool|string;

    public function decrypt(string $encryptedContent, string $date): string;


    public function prepareQuery($request): array;


    public function post(string $endpoint,object $request, array $headers, bool $isMultipart = false);
}
