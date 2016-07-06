<?php
namespace App\Providers;
use App\Http\Partner;
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
            	$partner = new Partner($request->input('customer_id'), 'travel');
		        
		        if ($partner->isAuth()) {
		            return $partner;
		        }

		        // @todo
		        // Powinno być oparte o Eloquent ORM
                // return User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}