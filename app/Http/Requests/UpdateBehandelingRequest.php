<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBehandelingRequest extends FormRequest
{
    public function authorize(): bool
    {
        $behandeling = $this->route('behandeling');
        $user = $this->user();

        if (! $behandeling || ! $user) {
            return false;
        }

        return $behandeling->user_id === $user->id || $user->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'klant_naam' => ['required', 'string', 'max:120'],
            'datum' => ['required', 'date'],
            'start_tijd' => ['required', 'date_format:H:i'],
            'duur_minuten' => ['required', 'integer', 'min:10', 'max:180'],
            'status' => ['required', 'in:gepland,bezig,afgerond,geannuleerd'],
            'opmerking' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
