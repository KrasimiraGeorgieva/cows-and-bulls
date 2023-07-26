<?php

namespace App\Http\Requests;

use App\Rules\UniqueFourDigits;
use Illuminate\Foundation\Http\FormRequest;

class CheckGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'guess' => ['required', 'numeric', 'digits:4', new UniqueFourDigits],
        ];
    }
}
