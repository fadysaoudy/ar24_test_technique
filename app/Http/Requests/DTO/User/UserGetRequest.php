<?php

namespace App\Http\Requests\DTO\User;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UserGetRequest extends Data
{
    /**
     * @param string|null $user_id
     * @param string|null $email
     * @param string|null $token
     * @param string|null $date
     */
    public function __construct(
        public ?string $user_id,
        public ?string $email,
        public ?string $token,
        public ?string $date,
    )
    {
        $this->token = config('ar24.ar24_token');
        $this->date = Carbon::now()->addHours(2)->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        $data = parent::toArray();

        $data['token'] = $this->token;
        $data['date'] = $this->date;

        return $data;
    }

    public static function rules(): array
    {
        return [
            'user_id' => ['required_if:email,null'],
            'email' => ['required_if:user_id,null', 'email'],
        ];
    }
}
