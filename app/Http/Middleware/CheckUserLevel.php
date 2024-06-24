<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserLevel
{
    public function handle(Request $request, Closure $next, $level)
    {
       // $user = session('user');

      //  if (is_null($user) || $user->level !== $level) {
        //    return redirect(route('home'));
        // }

        return $next($request);
    }
}
