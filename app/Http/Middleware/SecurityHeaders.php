<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Block the page from being embedded in iframes (clickjacking protection)
        $response->headers->set('X-Frame-Options', 'DENY');

        // Legacy XSS filter (still respected by older browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Enforce HTTPS (only for production — skip for localhost)
        if (!$request->isSecure() === false || app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Control referrer information sent on navigation
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Disable access to sensitive browser features not needed by the CMS
        $response->headers->set('Permissions-Policy',
            'accelerometer=(), camera=(), geolocation=(), gyroscope=(), magnetometer=(), microphone=(), payment=(), usb=()'
        );

        // Content Security Policy — restricts what resources can be loaded
        $cspParts = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://www.googletagmanager.com https://www.google-analytics.com",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' https://fonts.gstatic.com",
            "img-src 'self' data: blob: https:",
            "connect-src 'self' https://*.google-analytics.com https://*.analytics.google.com https://stats.g.doubleclick.net",
            "frame-src 'none'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "upgrade-insecure-requests",
        ];
        $response->headers->set('Content-Security-Policy', implode('; ', $cspParts));

        // Prevent information leakage via the Server header
        $response->headers->remove('X-Powered-By');
        $response->headers->set('Server', 'Anywhereroles');

        return $response;
    }
}
