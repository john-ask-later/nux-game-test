<?php

namespace App\Domain\Player;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlayerRequest extends FormRequest
{
    /**
     * Standard validation to prevent html errors and have litt meaningful dara
     */
    public function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:3', 'max:32', 'regex:/^[\sa-zA-Z0-9_-]+$/'],
            'phone' => ['required', 'string', 'min:9', 'max:16', 'regex:/^(\+?)[0-9\s]+$/'],
        ];
    }

}
