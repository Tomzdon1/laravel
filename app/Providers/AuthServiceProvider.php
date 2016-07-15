<?php
namespace App\Providers;
use App\Partner;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->has('customer_id')) {
                $matches = [];
                
                if (preg_match('/^([a-zA-Z])+/', $request->path(), $matches)) {
                    return Partner::where('customerId', $request->input('customer_id'))->where('offerType.'.$matches[0], true)->first();
                }

                return null;
            }
        });
    }
}