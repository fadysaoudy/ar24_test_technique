<?php

namespace App\Contracts;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserGetRequest;
use stdClass;

interface UserServiceInterface
{
    public function store(UserCreateRequest $request):string;
    public function get(UserGetRequest $request):stdClass;
}
