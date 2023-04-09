<?php

namespace App\Http\Controllers;

use App\Http\Requests\DTO\Email\EmailSendRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(): View
    {
        return view('pages.users.email.index');
    }
    public function store(EmailSendRequest $request)
    {
        dd($request);
        return $request;
    }

}
