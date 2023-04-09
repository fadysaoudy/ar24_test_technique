<?php

namespace App\Exceptions;

use Exception;

class AttachmentEmptyNameException extends Exception
{
    public static function EmptyName(): self
    {
        return new self("We can't extract a file name for the uploaded file. Please make sure the 'file_name' parameter or the 'name' parameter in the file object are not empty or incorrectly encoded.");
    }
}
