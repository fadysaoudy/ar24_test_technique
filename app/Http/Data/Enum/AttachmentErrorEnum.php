<?php

namespace App\Http\Data\Enum;

enum AttachmentErrorEnum: string
{
    case MISSING_USER_ID = 'missing_user_id';
    case ATTACHMENT_EMPTY_NAME = 'attachment_empty_name';
    case ATTACHMENT_TOO_BIG = 'attachment_too_big';
    case ATTACHMENT_MISSING_FILE = 'attachment_missing_file';
    case ATTACHMENT_NOT_EXISTS = 'attachment_not_exists';
    case ATTACHMENT_UNAVAILABLE = 'attachment_unavailable';


}
