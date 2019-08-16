<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Validate1 implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($rating)
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

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'message';
    }
}
