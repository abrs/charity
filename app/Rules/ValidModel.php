<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class ValidModel implements Rule
{
    private $model;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $model)
    {
        $this->model = $model;
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
        return !is_null($this->model::find($value)); 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return strtoupper('Wrong :attribute!!.');
    }
}
