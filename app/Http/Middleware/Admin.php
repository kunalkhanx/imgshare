<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if(!$user || $user->status !== 1){
            return redirect()->route('auth.login')->with('error', 'Please login to continue!');
        }
        if($user->role !== 'admin'){
            return response('', 404);
        }
        return $next($request);
    }
}
