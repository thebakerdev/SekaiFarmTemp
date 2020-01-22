<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    private $is_admin_route = false;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if ($this->is_admin_route) {
                return route('admin.login.login');
            }
            
            return route('index');
        }
    }

    /**
     * Override default handle and added  guard check for web-admin guard
     * 
     * @param \Illuminate\Http\Request  $request
     * @param Closure $next
     * @param Array $guards
     * @return 
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // Check if has admin guard
        if (count($guards) && $guards[0] === 'web-admin') {
            
            $this->is_admin_route = true;
        } // add another condition that will check user routes

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
