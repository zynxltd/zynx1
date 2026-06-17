<?php

namespace App\Http\Requests;

use App\Services\TurnstileVerifier;
use App\Support\ClientIp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Validator;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'company' => ['nullable', 'string', 'max:120'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $verifier = app(TurnstileVerifier::class);

            if (! $verifier->isEnabled()) {
                return;
            }

            if (! $verifier->verify($this->input('cf-turnstile-response'), ClientIp::from($this))) {
                $validator->errors()->add('captcha', 'Please complete the captcha verification.');
            }
        });
    }

    public function isSpam(): bool
    {
        if (filled($this->input('website'))) {
            return true;
        }

        $loadedAt = session('contact_form_loaded_at');

        if (! $loadedAt || Carbon::parse($loadedAt)->diffInSeconds(now()) < 3) {
            return true;
        }

        return false;
    }
}
