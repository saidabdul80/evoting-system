<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthLogin 
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
        $user  = session('user')??'';
        if ($user == '') {
            return route('login');
        }else{
            return $next($request);
        }
    }
}
