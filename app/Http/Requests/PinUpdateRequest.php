<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PinUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        $rules = [
            'pin' => ['required', 'string', 'digits:6'],
            'pin_confirmation' => ['required', 'same:pin'],
        ];

        if ($user->hasPin()) {
            $rules['current_pin'] = ['required', 'string', 'digits:6'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'pin.required' => 'PIN Persetujuan wajib diisi.',
            'pin.digits' => 'PIN Persetujuan harus 6 digit angka.',
            'pin_confirmation.required' => 'Konfirmasi PIN wajib diisi.',
            'pin_confirmation.same' => 'Konfirmasi PIN tidak cocok.',
            'current_pin.required' => 'PIN saat ini wajib diisi.',
            'current_pin.digits' => 'PIN saat ini harus 6 digit angka.',
        ];
    }
}
