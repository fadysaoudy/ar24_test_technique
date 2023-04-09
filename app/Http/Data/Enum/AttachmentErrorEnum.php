<?php

namespace App\Http\Data\Enum;

enum AttachmentErrorEnum: string
{
    const MISSING_USER_ID = 'missing_user_id';
    const ATTACHMENT_EMPTY_NAME = 'attachment_empty_name';
    const ATTACHMENT_TOO_BIG = 'attachment_too_big';
    const ATTACHMENT_MISSING_FILE = 'attachment_missing_file';
}
