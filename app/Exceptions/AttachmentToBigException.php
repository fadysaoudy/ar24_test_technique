<?php

namespace App\Exceptions;

use Exception;

class AttachmentToBigException extends Exception
{
    public static function tooBig(): self {
        return new self("The file you are trying to upload is too big. Please make sure the file size is within the allowed limit.");
    }
}
