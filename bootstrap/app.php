<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->prepend(\App\Http\Middleware\CmsSessionMiddleware::class);

        $middleware->alias([
            'cms.admin' => \App\Http\Middleware\AdminAuth::class,
            'superadmin' => \App\Http\Middleware\SuperAdminAuth::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Throwable $exception, \Illuminate\Http\Request $request) {
            $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->check();
            $is403 = ($exception instanceof \App\Exceptions\PermissionDeniedException) 
                     || ($exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException && $exception->getStatusCode() == 403);
            
            if ($isAdmin && $is403) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Unauthorized Access'], 403);
                }
                
                session()->flash('unauthorized_modal', true);
                
                $url = url()->previous();
                if (!$url || $url === url()->current()) {
                    return redirect()->route('cms.dashboard');
                }
                
                return redirect()->back();
            }
        });
    })->create();
