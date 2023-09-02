<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserTypeMiddleware
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
        $userType = session('user_type');

        error_log(print_r($userType, TRUE));

        // Check if the user is an admin
        if ($userType === 'admin') {
            // User is an admin, you can add specific logic here if needed

            // For example, you can set a variable to indicate admin status
            $request->attributes->add(['isAdmin' => true]);
        }

        if ($userType === 'user') {
            // User is an user, you can add specific logic here if needed

            // For example, you can set a variable to indicate admin status
            $request->attributes->add(['isUser' => true]);
        }

        return $next($request);
    }
}
