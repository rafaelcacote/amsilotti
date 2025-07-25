<?php

namespace App\Rules;

use App\Helpers\CpfHelper;
use Illuminate\Contracts\Validation\Rule;

class ValidCpf implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return CpfHelper::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O CPF informado não é válido.';
    }
}
