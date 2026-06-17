<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

    public function isSpam(): bool
    {
        if (filled($this->input('website'))) {
            return true;
        }

        $loadedAt = session('contact_form_loaded_at');

        if (! $loadedAt || now()->diffInSeconds($loadedAt) < 3) {
            return true;
        }

        return false;
    }
}
