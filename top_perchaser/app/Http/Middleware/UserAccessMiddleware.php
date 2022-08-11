<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->has('apiToken') && $request->session()->has('apiKey')) {
            return $next($request);
        } else {
            return redirect()->route('authorization.form')->with('message', 'You are trying to access without authentication, please enter your AppKey and Token..');
        }
        return $next($request);
    }
}
