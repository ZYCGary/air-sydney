<?php

namespace App\Http\Controllers\API\Traits;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules(): array
    {
        $password = (new Password)->length(10)
            ->requireUppercase()
            ->requireNumeric()
            ->requireSpecialCharacter();

        return ['required', 'string', $password, 'confirmed'];
    }
}
