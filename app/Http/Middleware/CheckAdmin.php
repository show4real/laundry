<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
     public function handle($request, Closure $next)
    {
        if (auth()->user()->admin!=1) {
            return response()->json(['error' => 'You don\'t have sufficient permission to access this resource'], 403);
          }
    
          return $next($request);
    }
}
