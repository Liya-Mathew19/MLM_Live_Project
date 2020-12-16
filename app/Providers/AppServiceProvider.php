<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Auth;
use View;
use DB;

class AppServiceProvider extends ServiceProvider
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
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        View()->composer('layouts.user',function($view){
        $userid=Auth::user()->id;
        $accounts=DB::select("select * from accounts where fk_user_id='$userid' and (acct_type='Primary' or status='Activated')");
        $view->with('accounts',$accounts);
        });
    }
}
