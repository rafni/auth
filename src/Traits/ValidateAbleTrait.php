<?php

namespace Rafni\Auth\Traits;

use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Validation\ValidationException;
/**
 * Class ValidateAbleTrait
 * @package Rafni\Auth\Traits
 */
trait ValidateAbleTrait
{
    /**
     * Runs the validator and throws exception if fails
     * 
     * @param array $attributes
     * @param array $rules
     * @param array $messages
     * @throws ValidationException
     */
    public function runValidator(array $attributes, array $rules, array $messages)
    {
        $validator = app(Validator::class)->make($attributes, $rules, $messages);
        $validator->validate();
    }
}