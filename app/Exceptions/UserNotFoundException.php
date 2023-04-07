<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    //
    public static function NotFound(): self
    {
        return new self("the user does not exist");
    }
}
