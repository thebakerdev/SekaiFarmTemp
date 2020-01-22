<?php

namespace App\Http\Middleware;

use Closure;
use App\admin;

class NotRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      if (admin::count() <= 0) {
        return redirect('/bluelogin/register');
      }

        return $next($request);
    }
}
