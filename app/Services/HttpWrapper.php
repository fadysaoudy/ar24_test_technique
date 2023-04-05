<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class HttpWrapper
{
    protected string $baseUrl;
    protected array $headers;
    protected bool $verify;
    protected int $timeout;

    protected ResponseWrapper $responseWrapper;

    public function __construct()
    {
        $this->setHeaders([
            'signature' => config('ar24.ar24_key'),
            'Content-type' => 'application/x-www-form-urlencoded',
        ]);
        $this->setBaseUrl(config('ar24.ar24_url'));
        $this->setVerify(true);
        $this->setTimeout(30);
        $this->responseWrapper = new ResponseWrapper();
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }


    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    public function setVerify(bool $verify): void
    {
        $this->verify = $verify;
    }

    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getVerify(): bool
    {
        return $this->verify;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @throws Exception
     */
    public function get($endpoint, $params = [])
    {
        $response = Http::withHeaders($this->headers)
            ->timeout($this->timeout)
            ->withOptions(['verify' => $this->verify])
            ->get($this->baseUrl . $endpoint, $params);

        return $this->responseWrapper->parse($response);

    }

    /**
     * @throws Exception
     */
    public function post($endpoint, $data): Response
    {

        $response = Http::withHeaders($this->headers)
            ->timeout($this->timeout)
            ->withOptions(['verify' => $this->verify])
            ->post($this->baseUrl . $endpoint, $data);

        return $response;
    }


}
