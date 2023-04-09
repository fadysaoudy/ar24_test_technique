<?php

namespace App\Http\Controllers;

use App\Contracts\ApiResponseHandlerInterface;
use App\Contracts\EmailServiceInterface;
use App\Contracts\HttpWrapperInterface;
use App\Http\Requests\DTO\Attachment\AttachmentUploadRequest;
use App\Http\Requests\DTO\Email\EmailSendRequest;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Session;

class EmailController extends Controller
{
    public function __construct(protected EmailServiceInterface $emailService)
    {

    }
    public function index(): View
    {
        return view('pages.users.email.index');
    }

    /**
     * @param EmailSendRequest $request
     * @return View|RedirectResponse
     */
    public function store(EmailSendRequest $request): View|RedirectResponse
    {
        try {
            $this->emailService->store($request);
        } catch (Exception $e) {
            return view('errors.user.user_errors', ['message' => $e->getMessage()]);

        }
        Queue::later(10, function () {
            Session::forget('success');
        });
        return redirect()->intended(RouteServiceProvider::HOME)->with('success', 'Email Sent Successfully.');
    }
}
