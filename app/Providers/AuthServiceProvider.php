<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\ShoppingCart;
use View;




class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       
            view()->composer('*', function($view)
            {
         if(Auth::check()){
           $cartItemes = ShoppingCart::where('user_id',Auth::id())
           ->where('order_id',null)
            ->get();
        }else{
        $cartItemes = ShoppingCart::where('order_id',null)
            ->where('ip_address',request()->ip())
            ->get();
        }

        
        View::share('cartItemes',$cartItemes);
    });
    }
}
