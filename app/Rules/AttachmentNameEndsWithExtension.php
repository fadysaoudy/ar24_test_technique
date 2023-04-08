<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;


class AttachmentNameEndsWithExtension implements ValidationRule


{


    /**
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strtoupper($value) == $value) {
            $fail('The :attribute must be uppercase.');
        }

    }

}
