<?php

namespace App\Http\Requests;

use Spatie\LaravelData\Data;

class UserDetailsRequest extends Data
{
    /**
     * @param string $id
     *
     */
    public function __construct(
        public string $id
    )
    {
    }

    public function rules(): array
    {
        return [
            'id' => ['required'],
        ];
    }
}
