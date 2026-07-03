<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBehandelingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        return $user->role === 'eigenaar';
    }

    public function rules(): array
    {
        return [
            'naam' => ['required', 'string', 'max:100'],
            'omschrijving' => ['required', 'string', 'max:255'],
            'duurminuten' => ['required', 'integer', 'min:10', 'max:480'],
            'prijs' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'is_actief' => ['required', 'boolean'],
            'opmerking' => ['nullable', 'string', 'max:255'],
        ];
    }
}
