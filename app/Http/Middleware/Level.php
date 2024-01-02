<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Level
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$levels): Response
    {
        $user = Auth::User();
        if(!$user) {
            return route('login.petugas');
        }
        
        foreach($levels as $level) {
            if($user->level === $level) {
                return $next($request);
            }
        }
        
        return route('login.petugas');
    }
}
