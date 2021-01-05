<?php

namespace App\Http\Requests\API;

use App\Http\Controllers\API\Traits\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
