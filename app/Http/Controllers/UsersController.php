<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Services\HttpWrapper;
use App\Services\ResponseWrapper;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Response;

class UsersController extends Controller
{
    public function __construct(
        protected HttpWrapper $httpWrapper,
    ){
        $this->httpWrapper = new HttpWrapper();
    }
    public function index(): View
    {
        return view('pages.users.create');
    }
    public function show(): View
    {
        return view('pages.users.index');
    }

    /**
     * @throws \Exception
     */

    public function store(UserCreateRequest $request)
    {
        try {
            $response = $this->httpWrapper->post('/user', $request->toArray());
            return ResponseWrapper::parse($response);
        } catch (Exception $e) {
            // handle the exception
            // you can log the error, return a custom error response, etc.
        }
    }

    public function sendEmail(): View
    {
        return view('pages.users.index');
    }
    public function receiveEmail(): View
    {
        return view('pages.users.index');
    }

}
