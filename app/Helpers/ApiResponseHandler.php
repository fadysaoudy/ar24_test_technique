<?php

namespace App\Helpers;

use App\Contracts\ApiResponseHandlerInterface;
use App\Exceptions\AttachmentEmptyNameException;
use App\Exceptions\AttachmentMissingFileException;
use App\Exceptions\AttachmentToBigException;
use App\Exceptions\UserAlreadyExistException;
use App\Exceptions\UserNotFoundException;
use App\Http\Data\Enum\AttachmentErrorEnum;
use App\Http\Data\Enum\ContentErrorEnum;
use App\Http\Data\Enum\DateErrorEnum;
use App\Http\Data\Enum\EmailErrorEnum;
use App\Http\Data\Enum\ResponseEnum;
use App\Http\Data\Enum\TokenErrorEnum;
use App\Http\Data\Enum\UserErrorEnum;
use Exception;

class ApiResponseHandler implements ApiResponseHandlerInterface
{
    /**
     * @throws UserAlreadyExistException
     * @throws Exception
     * @throws UserNotFoundException
     */
    public function handleJsonResponse($responseBody): void
    {

        $jsonContent = json_decode($responseBody);

        if ($jsonContent != null && $jsonContent->status == ResponseEnum::Error->value) {
            $exceptionMessage = $this->getExceptionMessage($jsonContent->slug);
            if ($exceptionMessage == null) {
                throw new Exception("Unknown error occurred");
            }

            else if ($exceptionMessage == UserErrorEnum::USER_NOT_CREATED) {
                throw new UserAlreadyExistException();
            }
            else if ($exceptionMessage == AttachmentErrorEnum::MISSING_USER_ID) {
                throw new UserNotFoundException();
            }
            else if ($exceptionMessage == AttachmentErrorEnum::ATTACHMENT_EMPTY_NAME) {
                throw new AttachmentEmptyNameException();
            }
            else if ($exceptionMessage == AttachmentErrorEnum::ATTACHMENT_MISSING_FILE) {
                throw new AttachmentMissingFileException();
            }
            else if ($exceptionMessage == AttachmentErrorEnum::ATTACHMENT_TOO_BIG) {
                throw new AttachmentToBigException();
            }
            else if ($exceptionMessage == UserErrorEnum::USER_NOT_EXIST) {
                throw new UserNotFoundException();
            }


            else {
                throw new Exception($exceptionMessage->value);
            }
        }

    }

    public function getExceptionMessage(string $slug): TokenErrorEnum|UserErrorEnum|DateErrorEnum|string|null
    {
        return match ($slug) {
            'missing_firstname' => UserErrorEnum::MISSING_FIRSTNAME,
            'missing_lastname' => UserErrorEnum::MISSING_LASTNAME,
            'missing_email' => UserErrorEnum::MISSING_EMAIL,
            'email_wrong_format' => UserErrorEnum::EMAIL_WRONG_FORMAT,
            'missing_address' => UserErrorEnum::MISSING_ADDRESS,
            'missing_city' => UserErrorEnum::MISSING_CITY,
            'missing_zipcode' => UserErrorEnum::MISSING_ZIPCODE,
            'missing_country' => UserErrorEnum::MISSING_COUNTRY,
            'error_country' => UserErrorEnum::ERROR_COUNTRY,
            'error_gender' => UserErrorEnum::ERROR_GENDER,
            'missing_company_siret' => UserErrorEnum::MISSING_COMPANY_SIRET,
            'missing_company_tva' => UserErrorEnum::MISSING_COMPANY_TVA,
            'error_company_siret' => UserErrorEnum::ERROR_COMPANY_SIRET,
            'user_not_created' => UserErrorEnum::USER_NOT_CREATED,
            'user_unavailable' => UserErrorEnum::USER_UNAVAILABLE,
            'token_invalid' => TokenErrorEnum::TOKEN_INVALID,
            'token_missing' => TokenErrorEnum::TOKEN_MISSING,
            'empty_date' => TokenErrorEnum::EMPTY_DATE,
            'invalid_date' => DateErrorEnum::INVALID_DATE,
            'expired_date' => DateErrorEnum::EXPIRED_DATE,
            'date_in_future' => DateErrorEnum::DATE_IN_FUTURE,
            'empty_signature' => UserErrorEnum::EMPTY_SIGNATURE,
            'missing_user_id' => UserErrorEnum::USER_NOT_EXIST,
            'user_account_not_confirmed' => UserErrorEnum::USER_ACCOUNT_NOT_CONFIRMED,
            'user_name_empty' => UserErrorEnum::USER_NAME_EMPTY,
            'user_not_exist' => AttachmentErrorEnum::MISSING_USER_ID,
            'attachment_too_big' => AttachmentErrorEnum::ATTACHMENT_TOO_BIG,
            'attachment_empty_name' => AttachmentErrorEnum::ATTACHMENT_MISSING_FILE,
            'attachment_missing_file' => AttachmentErrorEnum::ATTACHMENT_EMPTY_NAME,
            'same_sender_recipient_emails' => EmailErrorEnum::SAME_SENDER_RECIPIENT_EMAILS,
            'invalid_recipient' => EmailErrorEnum::INVALID_RECIPIENT,
            'invalid_email' => EmailErrorEnum::INVALID_EMAIL,
            'user_eula_not_accepted' => UserErrorEnum::USER_EULA_NOT_ACCEPTED,
            'attachment_not_exists' => AttachmentErrorEnum ::ATTACHMENT_NOT_EXISTS,
            'attachment_unavailable' => AttachmentErrorEnum ::ATTACHMENT_UNAVAILABLE,
            'content_exceeds_limit' => ContentErrorEnum ::CONTENT_EXCEEDS_LIMIT,
            'forbidden_html' => ContentErrorEnum ::FORBIDDEN_HTML,
            'error_no_content_no_attachment' => ContentErrorEnum ::ERROR_NO_CONTENT_NO_ATTACHMENT,

            default => null,
        };
    }
}
