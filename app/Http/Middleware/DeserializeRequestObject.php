<?php

namespace App\Http\Middleware;

use Closure;

use App\apiModels\RequestSchemaManager;
use App\apiModels\ObjectSerializer;

class DeserializeRequestObject
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $prototypesNamespace)
    {
        $objectSerializer = new ObjectSerializer();
        $requestSchema = $request->attributes->get('requestSchema');

        switch ($requestSchema->type) {
            case 'array':
                $requestObjectClassName = str_replace('_', '', substr(strstr($requestSchema->items->id, 'definitions/'), strlen('definitions/'))) .'[]';
                break;
            case 'object':
                $requestObjectClassName = str_replace('_', '', substr(strstr($requestSchema->id, 'definitions/'), strlen('definitions/')));
                break;
        }
        
        $deserializedRequestObject = $objectSerializer->deserialize(json_decode($request->getContent(), true), $prototypesNamespace.$requestObjectClassName);
        
        $request->attributes->add(['deserializedRequestObject' => $deserializedRequestObject]);

        return $next($request);
    }
}
