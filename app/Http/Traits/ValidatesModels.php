<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Validator;
use Illuminate\Http\Exception\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as Response;
use Illuminate\Support\MessageBag;

trait ValidatesModels
{

    /**
     * Validate the given model with it rules.
     *
     * @param  string  $prefix
     * @return MessageBag
     */
    public function validate($prefix = '')
    {
        if (env('APP_DEBUG', false)) {
            app('log')->debug("ValidatesModels starting for path ". get_class($this));
        }

        $data = [];
        $errors = [];

        if ($prefix !== '' && substr($prefix, -1) !== '.') {
            $prefix .= '.';
        }
        
        foreach (static::$attributeMap as $key => $value) {
            if (isset($this->{$key})) {
                $data[$key] = $this->{$key};
            }
            if (is_subclass_of($this->{$key}, 'App\apiModels\ApiModel')) {
                $errors = $this->{$key}->validate($key)->merge($errors);
            } elseif (is_array($this->{$key})) {
                foreach ($this->{$key} as $key => $arrayElement) {
                    if (is_subclass_of($arrayElement, 'App\apiModels\ApiModel')) {
                        $errors = $arrayElement->validate($key)->merge($errors);
                    }
                }
            }
        }

        $dataArray = static::objectToArray($data);
        $validator = $this->getValidationFactory()->make($dataArray, static::$validators);
        $errors = $validator->errors()->merge($errors);

        $errorsPrefixed = new MessageBag();

        foreach ($errors->messages() as $key => $messages) {
            foreach ($messages as $message) {
                $errorsPrefixed->add($prefix.$key, $message);
            }
        }

        if (env('APP_DEBUG', false)) {
            app('log')->debug('ValidatesModels end');
        }

        return $errorsPrefixed;
    }

    /**
     * Convert an objects to multi-dimensional associative array.
     *
     * @param  Object $object
     * @return array
     */
    public static function objectToArray($object)
    {
        $results = [];

        foreach ((array)$object as $key => $value) {
            $results[$key] = !is_scalar($value) ? static::objectToArray($value) : $value;
        }

        return $results;
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
