<?php

namespace App\Http\Data\Enum;

enum UserErrorEnum: string
{
    case MISSING_FIRSTNAME = 'missing_firstname';
    case MISSING_LASTNAME = 'missing_lastname';
    case MISSING_EMAIL = 'missing_email';
    case EMAIL_WRONG_FORMAT = 'email_wrong_format';
    case MISSING_ADDRESS = 'missing_address';
    case MISSING_CITY = 'missing_city';
    case MISSING_ZIPCODE = 'missing_zipcode';
    case MISSING_COUNTRY = 'missing_country';
    case ERROR_COUNTRY = 'error_country';
    case ERROR_GENDER = 'error_gender';
    case MISSING_COMPANY_SIRET = 'missing_company_siret';
    case MISSING_COMPANY_TVA = 'missing_company_tva';
    case ERROR_COMPANY_SIRET = 'error_company_siret';
    case USER_NOT_CREATED = 'user_not_created';
    case USER_UNAVAILABLE = 'user_unavailable';

}
