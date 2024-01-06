<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class adminMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(auth()->check() && auth()->user()->type == 'admin'){
            return $next($request);
           }else{
             return response()->json(['status'=>403, 'error'=>'unauthorized'], 403);
           }

        // return $next($request);
    }
}
