<?php

namespace Test\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class UsernameValidationRole extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {  
        Validator::extend('user_name', function($attribute,$value,$parameters,$validator){
            if(empty($value))
                return false;
            for($i=0;$i<strlen($value);$i++)
                if(!ctype_alpha($value[$i]) &&! ctype_digit($value[$i])&& $value[$i]!='_')
                    return false;
            return true;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
