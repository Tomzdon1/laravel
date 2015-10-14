<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as Response;

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
    public function validate($errorClass = null, array $rules = [], array $messages = [], array $customAttributes = []) {
        $data = [];

        if (!count($rules)) {
            $rules = static::$validators;
        }

        foreach (static::$attributeMap as $key => $value) {
            $data[$key] = &$this->{$key};
        }

        $validator = $this->getValidationFactory()->make($data, $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $errors = [];

            if ($errorClass) {
                foreach ($validator->errors()->getMessages() as $property => $errorsMessage) {
                    $data = [];
                    $data['property'] = $property;
                    $data['errors'] = $errorsMessage;
                    $errors[] = new $errorClass($data);
                }
            }
            else {
                $errors = $validator->errors()->getMessages();
            }

            throw new HttpResponseException(new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY));
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
