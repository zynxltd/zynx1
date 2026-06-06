<?php

namespace App\Http\Requests;

use App\Services\BookingService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:120', 'regex:/^[\pL\s\'\-\.]+$/u'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'company' => ['nullable', 'string', 'max:120'],
            'phone' => ['required', 'string', 'regex:/^\+?[0-9][0-9\s\-().]{6,18}[0-9]$/'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'scheduled_at' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.regex' => 'Name can only contain letters, spaces, hyphens and apostrophes.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'Please enter a phone number so we can reach you.',
            'phone.regex' => 'Please enter a valid phone number (e.g. +447123456789).',
            'message.required' => 'Please tell us what you would like to discuss.',
            'message.min' => 'Please provide at least 10 characters about what you would like to discuss.',
            'scheduled_at.required' => 'Please select a date and time for your consultation.',
        ];
    }

    public function attributes(): array
    {
        return [
            'scheduled_at' => 'date and time',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $booking = app(BookingService::class);

            if (! $booking->slotIsAvailable($this->input('scheduled_at'))) {
                $validator->errors()->add(
                    'scheduled_at',
                    'That time slot is no longer available. Please choose another.'
                );
            }
        });
    }
}
