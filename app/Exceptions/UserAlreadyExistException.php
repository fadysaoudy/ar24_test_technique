<?php

namespace App\Exceptions;

use Exception;

class UserAlreadyExistException extends Exception
{

    public static function EmailExist(): self
    {
        return new self("An AR24 account already exists with this email address. Please use another email address or update existing AR24 account with this email address");
    }
}
