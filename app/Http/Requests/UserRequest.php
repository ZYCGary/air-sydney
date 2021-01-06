<?php

namespace App\Http\Requests;

use App\Http\Controllers\API\Traits\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JetBrains\PhpStorm\ArrayShape;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [

        ];
    }
}
