<?php

namespace App\Http\Requests\DTO\Attachment;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\File;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Data;

class AttachmentUploadRequest extends Data
{
    /**
     * @param string|null $token
     * @param string|null $date
     * @param string|null $id_user
     * @param $file
     */

    public function __construct(
        public ?string $token,
        public ?string $date,
        public ?string $id_user,
        #[File]
        #[Mimes('jpg', 'png', 'jpeg', 'pdf')]
        public         $file,


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


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public static function rules(): array
    {

        return [
            'file' => ['required', 'file','mimes:jpg,jpeg,png,pdf'],
            'id_user' => ['required', 'numeric'],
        ];
    }
}
