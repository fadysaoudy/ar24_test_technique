<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class UserCreateRequest  extends Data
{
    /**
     * @param string $firstname
     * @param string $lastname
     * @param string $email
     * @param string $country
     * @param string $address1
     * @param string $statut
     * @param string $company
     * @param string $city
     * @param string $zipcode
     * @param string $gender
     * @param string $password
     * @param ?string $company_siret
     * @param ?string $company_tva
     * @param ?string $address2
     * @param bool $confirmed
     * @param ?string $billing_email
     * @param bool $notify_ev
     * @param bool $notify_ar
     * @param bool $notify_ng
     * @param bool $notify_consent
     * @param bool $notify_eidas_to_valid
     * @param bool $notify_recipient_update
     * @param bool $notify_waiting_ar_answer
     * @param bool $is_legal_entity
     */
    public function __construct(
        public ?string $token,
        public ?string $date,
        public string $firstname,
        public string $lastname,
        public string $email,
        public string $country,
        public string $address1,
        public string $statut,
        public string $company,
        public string $city,
        public string $zipcode,
        public string $gender,
        public string $password,
        public ?string $company_siret,
        public ?string $company_tva,
        public ?string $address2,
        public bool $confirmed,
        public ?string $billing_email,
        public bool $notify_ev,
        public bool $notify_ar,
        public bool $notify_ng,
        public bool $notify_consent,
        public bool $notify_eidas_to_valid,
        public bool $notify_recipient_update,
        public bool $notify_waiting_ar_answer,
        public bool $is_legal_entity,
    ) {
        $this->token = config('ar24.ar24_token');
        $this->date = Carbon::now()->format('Y-m-d H:i:s');
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
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => ['required', 'email'],
            'country' => ['required', 'string'],
            'address1' => ['required', 'string'],
            'statut' => ['required', 'string'],
            'company' => ['required', 'string'],
            'city' => ['required', 'string'],
            'zipcode' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'password' => ['required', 'string'],
            'company_siret' => ['nullable', 'string'],
            'company_tva' => ['nullable', 'string'],
            'address2' => ['nullable', 'string'],
            'confirmed' => ['required', 'boolean'],
            'billing_email' => ['nullable', 'email'],
            'notify_ev' => ['required', 'boolean'],
            'notify_ar' => ['required', 'boolean'],
            'notify_ng' => ['required', 'boolean'],
            'notify_consent' => ['required', 'boolean'],
            'notify_eidas_to_valid' => ['required', 'boolean'],
            'notify_recipient_update' => ['required', 'boolean'],
            'notify_waiting_ar_answer' => ['required', 'boolean'],
            'is_legal_entity' => ['required', 'boolean']
        ];
    }
}
