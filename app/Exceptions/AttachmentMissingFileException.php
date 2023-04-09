<?php

namespace App\Exceptions;

use Exception;

class AttachmentMissingFileException extends Exception
{

    public static function MissingFile(): self
    {
        return new self("The file parameter is missing or not correctly filled. Please make sure you are sending a valid file object in the request.");
    }
}
