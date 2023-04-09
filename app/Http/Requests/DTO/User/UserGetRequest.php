<?php

namespace App\Http\Requests\DTO\User;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UserGetRequest extends Data
{
    /**
     * @param string|null $user_id
     * @param string|null $email
     * @param string|null $date
     */
    public function __construct(
        public ?string $user_id,
        public ?string $email,
        public ?string $date,
    )
    {

        $this->date = Carbon::now()->addHours(2)->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        $data = parent::toArray();

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
