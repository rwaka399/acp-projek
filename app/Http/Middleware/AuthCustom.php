<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        // if ($request->session()->has('token')) {
        //     return $next($request);
        // } else {
        //     return redirect()->route('loginpage');
        // }

        try {
            if ($request->session()->has('token')) {

                if ($role && auth()->check() && auth()->user()->role !== $role) {

                    return redirect()->route('unauthorized');
                }
                return $next($request);
            } else {
                return redirect()->route('loginpage');
            }
        } catch (\Throwable $th) {
            return redirect()->route('loginpage');
        }
    }
}
