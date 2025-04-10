<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Validation\Rules\Password;
use ZxcvbnPhp\Zxcvbn;

trait PasswordValidationRules
{
    protected function passwordRules(): array
    {
        return [
            'bail',
            'required',
            'string',
            Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(0),
            fn ($attribute, $value, $fail) => $this->zxcvbnRule($value, $fail),
            'confirmed',
        ];
    }

    /** @see https://github.com/bjeavons/zxcvbn-php */
    private function zxcvbnRule(string $value, \Closure $fail): void
    {
        $score = (new Zxcvbn())->passwordStrength($value)['score'];
        if ($score < 3) {
            $fail(__('Pour votre sécurité, veuillez choisir un mot de passe plus complexe.'));
        }
    }
}
