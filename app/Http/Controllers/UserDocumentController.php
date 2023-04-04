<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UserDocumentController extends Controller
{
    public function index(): View
    {
        return view('pages.users.documents.index');
    }
    public function store(): View
    {
        return view('pages.users.documents.index');
    }
}
