<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CmsSessionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Set different session configuration for CMS routes
        if ($request->is('cms*')) {
            // Only override if the driver is database (maintains local functionality)
            if (config('session.driver') === 'database') {
                config(['session.connection' => config('database.default')]);
                config(['session.table' => 'cms_sessions']);
            }
            
            // Set a different cookie name for CMS to prevent session ID conflicts with public routes
            config(['session.cookie' => config('session.cookie') . '_cms']);
        }

        return $next($request);
    }
}