<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUserLoggedInMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       
        
        if ($request->session()->has("user")) {
            if (session()->get("user")->role_id == 2) {
                return $next($request);
            } else {
                return redirect()->route("login.create");
            }
        }else {
             return redirect()->route("login.create");
        }
        
       

        
    }
}
