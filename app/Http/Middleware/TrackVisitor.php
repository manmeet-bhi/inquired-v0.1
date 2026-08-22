<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tracking for CMS routes, API routes, or if explicitly excluded
        if ($request->is('cms*') || $request->is('api*') || $request->is('_debugbar*')) {
            return $next($request);
        }

        // 1. Capture Initial Referrer (Session Level)
        $sessionId = Session::getId();
        $currentUrl = $request->fullUrl();
        $referrer = $request->header('referer');

        // If session doesn't have a referrer yet, and we have one from external
        // We can check the DB directly to see if 'referrer' is null for this session
        // Or just trust the session behavior. 
        // Optimization: Use Session facade to check if we already logged it to avoid DB writes on every request?
        // Actually, the requirement asks to upgrade sessions table.
        // Let's update the session table if referrer is currently null.
        
        // We only want to set referrer if it's NOT from our own domain (approximate check)
        // or just capture whatever the first referrer is.
        
        $sessionExists = DB::table('sessions')->where('id', $sessionId)->exists();
        
        // If session doesn't exist in DB and we are using database driver, 
        // we should create it now so the activity log can link to it.
        if (!$sessionExists && config('session.driver') === 'database') {
            try {
                DB::table('sessions')->insertOrIgnore([
                    'id' => $sessionId,
                    'ip_address' => substr($request->ip(), 0, 45),
                    'user_agent' => substr($request->userAgent(), 0, 255),
                    'payload' => base64_encode(serialize([])),
                    'last_activity' => time(),
                ]);
                $sessionExists = true;
            } catch (\Exception $e) {
                // Fallback to second check in case of race conditions
                $sessionExists = DB::table('sessions')->where('id', $sessionId)->exists();
            }
        }
        
        if ($sessionExists) {
             // We can optimistically try to update if it's null.
             if ($referrer && !Session::has('recorded_referrer')) {
                 DB::table('sessions')
                    ->where('id', $sessionId)
                    ->whereNull('referrer') // Only set if empty
                    ->update(['referrer' => $referrer]);
                    
                 Session::put('recorded_referrer', true);
             }
        }

        // 2. Log Page View (Activity)
        try {
            // Only log if session exists in DB (to avoid foreign key violation)
            if ($sessionExists) {
                DB::table('session_activities')->insert([
                    'session_id' => $sessionId,
                    'url' => substr($currentUrl, 0, 1000), // Protect against overly long URLs
                    'referrer' => $referrer ? substr($referrer, 0, 1000) : null,
                    'created_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('TrackVisitor Error: ' . $e->getMessage());
        }

        return $next($request);
    }
}
