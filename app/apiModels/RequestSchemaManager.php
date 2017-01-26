<?php

namespace App\apiModels;

use FR3D\SwaggerAssertions\SchemaManager;

/**
 * Expose methods for navigate across the Swagger definition schema.
 *
 * Method getResponse is override to get request.
 */
class RequestSchemaManager extends SchemaManager {
	
	/**
     * @param string $path Swagger path template.
     * @param string $method
     * @param int $httpCode
     *
     * @return stdClass
     */
	public function getResponse($path, $method, $httpCode)
    {
        $method = strtolower($method);
        $pathSegments = function ($path, $method) {
            return [
                'paths',
                $path,
                $method,
                'parameters'
            ];
        };

        if ($this->hasPath($pathSegments($path, $method))) {
            $response = $this->getPath($pathSegments($path, $method))[0];
        } else {
            $response = $this->getPath($pathSegments($path, $method, 'default'));
        }

        return $this->resolveSchemaReferences($response);
    }
}