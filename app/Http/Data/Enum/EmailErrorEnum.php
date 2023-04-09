<?php

namespace App\Http\Data\Enum;

enum EmailErrorEnum: string
{
    case MISSING_EMAIL = 'missing_email';
    case SAME_SENDER_RECIPIENT_EMAILS = 'same_sender_recipients_emails';
    case INVALID_RECIPIENT = 'invalid_recipient';
    case INVALID_EMAIL= 'invalid_email';
    case GROUP_NOTE_EXIST = 'group_not_exist';
}
