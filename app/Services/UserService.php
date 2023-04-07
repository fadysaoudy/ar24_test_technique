<?php

namespace App\Services;

use App\Contracts\HttpWrapperInterface;
use App\Contracts\UserServiceInterface;
use App\Exceptions\UserAlreadyExistException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserGetRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use stdClass;

class UserService implements UserServiceInterface
{
    public function __construct(  protected HttpWrapperInterface $httpWrapper)
    {

    }

    /**
     * @throws Exception
     */
    public function store(UserCreateRequest $request):string
    {

        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        try {
            $response = $this->httpWrapper->post('/user', $request, $headers);
        }

        catch (UserAlreadyExistException $e) {

            Log::error($e);
            throw UserAlreadyExistException::EmailExist();
        }
        catch (Exception $e) {
            Log::error($e);
            throw new Exception($e->getMessage());
        }
        return $response;

    }

    /**
     * @throws Exception
     */
    public function get(UserGetRequest $request):stdClass
    {

        $headers = ['Content-Type' => 'application/x-www-form-urlencoded'];
        try {
            $response = $this->httpWrapper->get('/user', $request, $headers);
            $cleanedResponse = substr($response, stripos($response, "result") - 1);
            $cleanedResponse = "{" . $cleanedResponse;
            $cleanedResponse = json_decode($cleanedResponse);
            $cleanedResponse = collect($cleanedResponse);
            $cleanedResponse = $cleanedResponse->toArray();
            $cleanedResponse = $cleanedResponse['result'];
        }

        catch (UserNotFoundException $e) {
            $exception = $e->getMessage();
            Log::error($e);
            throw UserNotFoundException::NotFound();
        }
        catch (Exception $e) {
            Log::error($e);
            throw new Exception('An error occurred while processing your request. Please try again later.');

        }

        return $cleanedResponse;

    }
}
