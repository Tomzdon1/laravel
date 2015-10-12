<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;

trait ValidatesModels
{
    /**
     * Validate the given model with the given rules.
     *
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     */
    public function validate(array $rules = [], array $messages = [], array $customAttributes = []) {
        $data = [];

        if (!count($rules)) {
            $rules = static::$validators;
        }

        foreach (static::$attributeMap as $key => $value) {
            $data[$key] = &$this->{$key};
        }

        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new HttpResponseException(new JsonResponse($validator->errors()->getMessages(), 422));
        }
    }

    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app('validator');
    }
}
