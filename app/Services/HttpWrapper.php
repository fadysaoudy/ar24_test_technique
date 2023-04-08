<?php

namespace App\Services;

use App\Contracts\HttpWrapperInterface;
use App\Exceptions\UserAlreadyExistException;
use App\Exceptions\UserNotFoundException;
use App\Http\Data\Enum\DateErrorEnum;
use App\Http\Data\Enum\ResponseEnum;
use App\Http\Data\Enum\TokenErrorEnum;
use App\Http\Data\Enum\UserErrorEnum;
use App\Http\Requests\DTO\User\UserGetRequest;
use CURLFile;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class HttpWrapper implements HttpWrapperInterface
{
    protected string $baseUrl;
    protected string $signature;
    protected bool $verify;
    protected int $timeout;
    protected string $token;
    protected string $api_secret;


    const HASH_ALGO = 'sha256';
    const CIPHER_ALGO = 'aes-256-cbc';

    public function __construct()
    {
        $this->setBaseUrl(config('ar24.ar24_url'));
        $this->setToken(config('ar24.ar24_token'));
        $this->setSecret(config('ar24.ar24_key'));
        $this->setVerify(true);
        $this->setTimeout(30);


    }

    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function setSecret(string $api_secret): void
    {
        $this->api_secret = $api_secret;
    }

    public function setVerify(bool $verify): void
    {
        $this->verify = $verify;
    }

    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
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
    public function get($endpoint, UserGetRequest $data, $headers): string
    {
        $params = $this->prepareQuery($data);
        $response = Http::withHeaders($headers)
            ->withHeaders(['signature' => $this->makeSignature($data->date)])
            ->timeout($this->timeout)
            ->withOptions(['verify' => $this->verify])
            ->get($this->baseUrl . $endpoint, $params);
        return $response->body();


    }


    /**
     * @throws Exception
     */
    public function post($endpoint, $request, array $headers): string
    {
        $response = Http::withHeaders($headers)
            ->withHeaders(['signature' => $this->makeSignature($request->date)])
            ->timeout($this->timeout)
            ->withOptions([$this->verify])
            ->withBody(http_build_query($request), 'application/x-www-form-urlencoded')
            ->post($this->baseUrl . $endpoint);
        return $response->body();


    }
//    public function postAttachment($endpoint, $request, array $headers): string
//    {
//        $client = new Client();
//
//        try {
//            $response = $client->post('https://sandbox.ar24.fr/api/attachment', [
//                'multipart' => [
//                    [
//                        'name' => 'token',
//                        'contents' => $request->token
//                    ],
//                    [
//                        'name' => 'date',
//                        'contents' => $request->date
//                    ],
//                    [
//                        'name' => 'id_user',
//                        'contents' => $request->id_user
//                    ],
//                    [
//                        'name' => 'file',
//                        'contents' => fopen($request->file, 'r')
//                    ]
//                ],
//                'headers' => [
//                    'signature' => $this->makeSignature($request->date)
//                ]
//            ]);
//
//            dump( $response->getBody());
//            dump($this->decrypt($response->getBody(),$request->date));
//        } catch (RequestException $e) {
//            echo $e->getMessage();
//        }
//
//
//return '';
//
//    }
    public function postAttachment( $endpoint,  $request,  $headers): string
    {
        $client = new Client();
        $signature = $this->makeSignature($request->date);

        try {
            $response = $client->post($this->baseUrl . $endpoint, [
                'multipart' => [
                    [
                        'name' => 'token',
                        'contents' => $request->token
                    ],
                    [
                        'name' => 'date',
                        'contents' => $request->date
                    ],
                    [
                        'name' => 'id_user',
                        'contents' => $request->id_user
                    ],
                    [
                        'name' => 'file',
                        'contents' => fopen($request->file, 'r')
                    ]
                ],
                'headers' => [
                    'signature' => $signature
                ]
            ]);

            dump($response->getBody());
            dump($this->decrypt($response->getBody(), $request->date));
        } catch (RequestException $e) {
            echo $e->getMessage();
        }
        return  ' ';
    }


    public function prepareQuery($request): array
    {

        $id_user = $request->user_id;
        $email = $request->email;
        $query['token'] = $request->token;
        $query['date'] = $request->date;
        $query['id_user'] = $id_user;
        $query['email'] = $email;

        return $query;
    }

    public static function makeSignature($date): bool|string
    {
        $privateKey = config('ar24.ar24_key');
        $hashedPrivateKey = hash('sha256', $privateKey);
        $iv = mb_strcut(hash('sha256', $hashedPrivateKey), 0, 16, 'UTF-8');
        return openssl_encrypt($date, 'aes-256-cbc', $hashedPrivateKey, false, $iv);
    }

    /**
     * @throws UserAlreadyExistException
     * @throws Exception
     */
    public function handleJsonResponse($responseBody): void
    {

        $jsonContent = json_decode($responseBody);

        if ($jsonContent != null && $jsonContent->status == ResponseEnum::Error->value) {
            $exceptionMessage = $this->getExceptionMessage($jsonContent->slug);

            if ($exceptionMessage == null) {
                throw new Exception("Unknown error occurred");
            }

            if ($exceptionMessage == UserErrorEnum::USER_NOT_CREATED) {
                throw  UserAlreadyExistException::EmailExist();
            }
            else if ($exceptionMessage == UserErrorEnum::USER_NOT_EXIST) {
                throw new UserNotFoundException();
            } else {
                throw new Exception($exceptionMessage->value);
            }
        }

    }

    public function decrypt($encryptedContent, $date): string
    {
        $key = hash(static::HASH_ALGO, $date . $this->api_secret);
        $iv = mb_strcut(hash(static::HASH_ALGO, $this->api_secret), 0, 16, 'UTF-8');

        $content = openssl_decrypt($encryptedContent, static::CIPHER_ALGO, $key, false, $iv);

        return $content !== false ? $content : '';
    }

    public function getExceptionMessage(string $slug): TokenErrorEnum|UserErrorEnum|DateErrorEnum|null
    {
        return match ($slug) {
            'missing_firstname' => UserErrorEnum::MISSING_FIRSTNAME,
            'missing_lastname' => UserErrorEnum::MISSING_LASTNAME,
            'missing_email' => UserErrorEnum::MISSING_EMAIL,
            'email_wrong_format' => UserErrorEnum::EMAIL_WRONG_FORMAT,
            'missing_address' => UserErrorEnum::MISSING_ADDRESS,
            'missing_city' => UserErrorEnum::MISSING_CITY,
            'missing_zipcode' => UserErrorEnum::MISSING_ZIPCODE,
            'missing_country' => UserErrorEnum::MISSING_COUNTRY,
            'error_country' => UserErrorEnum::ERROR_COUNTRY,
            'error_gender' => UserErrorEnum::ERROR_GENDER,
            'missing_company_siret' => UserErrorEnum::MISSING_COMPANY_SIRET,
            'missing_company_tva' => UserErrorEnum::MISSING_COMPANY_TVA,
            'error_company_siret' => UserErrorEnum::ERROR_COMPANY_SIRET,
            'user_not_created' => UserErrorEnum::USER_NOT_CREATED,
            'user_unavailable' => UserErrorEnum::USER_UNAVAILABLE,
            'token_invalid' => TokenErrorEnum::TOKEN_INVALID,
            'token_missing' => TokenErrorEnum::TOKEN_MISSING,
            'empty_date' => TokenErrorEnum::EMPTY_DATE,
            'invalid_date' => DateErrorEnum::INVALID_DATE,
            'expired_date' => DateErrorEnum::EXPIRED_DATE,
            'date_in_future' => DateErrorEnum::DATE_IN_FUTURE,
            'empty_signature' => UserErrorEnum::EMPTY_SIGNATURE,
            'user_not_exist' => UserErrorEnum::USER_NOT_EXIST,
            default => null,
        };
    }

}

//$response = Http::withHeaders([
//    "accept: application/json",
//    "content-type: application/json"
//])->post('https://staging.consume.com/testing', $postArray)->json();
//$response = Http::withHeaders([
//    "accept" => "application/json",
//    "content-type" => "application/json"
//])->post('https://staging.consume.com/testing', $postArray)->json()
