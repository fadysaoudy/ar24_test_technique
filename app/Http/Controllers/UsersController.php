<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(): View
    {
        return view('pages.users.create');
    }
    public function show(): View
    {
        return view('pages.users.index');
    }
    public function store(): View
    {
        return view('pages.users.index');
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
