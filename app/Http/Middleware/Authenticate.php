<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $session = Session::get('token');

        if($session != '') {
            return null;
        }
        
        return route('loginpage');

        // // return $request->expectsJson() ? null : route('/');


        // if(!Session::has('token')) {
        //     return route('loginpage');
        // }

        // return null;
    }
}
