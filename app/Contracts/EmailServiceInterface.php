<?php

namespace App\Contracts;

use App\Http\Requests\DTO\Email\EmailSendRequest;

interface EmailServiceInterface
{
    /**
     * @param EmailSendRequest $request
     */
    public function store(EmailSendRequest $request);
}
