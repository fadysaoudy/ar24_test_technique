<?php

namespace App\Http\Controllers;

use App\Contracts\UserServiceInterface;
use App\Exceptions\UserAlreadyExistException;
use App\Exceptions\UserNotFoundException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserGetRequest;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;
use stdClass;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;
class UsersController extends Controller
{

    public function __construct(
        protected UserServiceInterface $userService,

    )
    {
    }

    public function index(): View
    {
        return view('pages.users.create');
    }

    public function show(): View
    {
        return view('pages.users.show');
    }

    public function getUserByMail(UserGetRequest $request): View|string|stdClass
    {
        try {
            $user = $this->userService->get($request);
            return view('pages.users.index', ['user' => $user]);
        } catch (UserNotFoundException $e) {
            return view('errors.user.user_errors', ['message' => $e->getMessage()]);
        } catch (Exception $e) {
            return view('errors.user.user_errors', ['message' => 'An error occurred while processing your request. Please try again later.']);
        }

    }


    /**
     * @throws Exception
     */

    public function store(UserCreateRequest $request): string
    {
        try {

        $this->userService->store($request);
        } catch (UserAlreadyExistException $e) {
            return view('errors.user.user_errors', ['message' => $e->getMessage()]);

        } catch (Exception $e) {
            return view('errors.user.user_errors', ['message' => 'An error occurred while processing your request. Please try again later.']);

        }

        // Clear success message from session after 3 seconds
        Queue::later(10, function () {
            Session::forget('success');
        });
        return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'User created successfully.');
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
