<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneValidity implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match("/^\+?\d[0-9-]{9,12}/", $value);
        return true;
        //regex:((?=.*\\d)(?=.*[A-Z]).{6,6})
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please use valid phone number';
    }
}
