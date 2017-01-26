<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tue\ParsingTemplate\TemplateParserFromObject;

class FromObjectTemplateParsingServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('TemplateParserFromObject', function () {
            return new TemplateParserFromObject();
        });

    }
    
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [TemplateParserFromObject::class];
    }
}
