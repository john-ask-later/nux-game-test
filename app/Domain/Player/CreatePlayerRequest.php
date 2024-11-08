<?php

namespace App\Domain\Player;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlayerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:32', 'regex:/^[a-zA-Z0-9_-]+$/'],
            'phone' => ['required', 'string', 'min:9', 'max:16', 'regex:/^(\+?)[0-9\s]+$/'],
        ];
    }
}
