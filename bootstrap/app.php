<?php

require_once __DIR__.'/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__.'/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

// Required with Bschmitt\Amqp
$app->withFacades();
class_alias('Illuminate\Support\Facades\App', 'App');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    // Illuminate\Cookie\Middleware\EncryptCookies::class,
    // Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    // Illuminate\Session\Middleware\StartSession::class,
    // Illuminate\View\Middleware\ShareErrorsFromSession::class,
    // Laravel\Lumen\Http\Middleware\VerifyCsrfToken::class,
    App\Http\Middleware\WrapResponse::class,
    App\Http\Middleware\RequestResponseLogger::class,
]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'request_validate' => App\Http\Middleware\RequestValidate::class,
    'deserialize_request_object' => App\Http\Middleware\DeserializeRequestObject::class,
]);

/*
|--------------------------------------------------------------------------
| Load custom configure files
|--------------------------------------------------------------------------
*/
$app->configure('amqp');

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AuthServiceProvider::class);
$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\EsbServiceProvider::class);
$app->register(App\Providers\PdfPrintingServiceProvider::class);
$app->register(App\Providers\SMSSendingServiceProvider::class);
$app->register(App\Providers\MailSendingServiceProvider::class);
$app->register(App\Providers\FromObjectTemplateParsingServiceProvider::class);
$app->register(App\Providers\PolicySendingServiceProvider::class);
$app->register(App\Providers\RequestResponseLoggerServiceProvider::class);
$app->register(Jenssegers\Mongodb\MongodbServiceProvider::class);
$app->register(Monarobase\CountryList\CountryListServiceProvider::class);
$app->register(Bschmitt\Amqp\LumenServiceProvider::class);

$app->withEloquent();
 
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
    require __DIR__.'/../app/Http/routes.php';
});

return $app;
