<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class DebugController extends Controller
{
    public function debugEmail()
    {
        try {
            // Test Database Connection first
            try {
                DB::connection()->getPdo();
                $dbStatus = "Database connection successful. Database name: " . DB::connection()->getDatabaseName();
            } catch (\Exception $e) {
                $dbStatus = "Database connection failed: " . $e->getMessage();
            }

            // Test Email
            $data = ['message' => 'This is a test email from the debug route.'];
            
            Mail::raw('Debug email test successful! ' . $dbStatus, function ($message) {
                $message->to(config('mail.from.address'))
                        ->subject('Debug Email Test');
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Email sent successfully to ' . config('mail.from.address'),
                'db_status' => $dbStatus,
                'mail_config' => [
                    'mailer' => config('mail.default'),
                    'from' => config('mail.from'),
                    'resend_api_key' => config('resend.api_key') ? 'Set' : 'Not Set',
                    'resend_domain' => config('resend.domain'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'db_status' => $dbStatus ?? 'Unknown',
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function testResend($email)
    {
        try {
            Mail::raw('🎉 Resend is working perfectly! This test email confirms your Resend configuration is correct.', function ($message) use ($email) {
                $message->to($email)
                        ->subject('✅ Resend Test - AnywhereRoles');
            });

            return response()->json([
                'status' => 'success',
                'message' => "Test email sent successfully to {$email}",
                'config' => [
                    'mailer' => config('mail.default'),
                    'from_address' => config('mail.from.address'),
                    'from_name' => config('mail.from.name'),
                    'resend_api_key' => config('resend.api_key') ? 'Set ✅' : 'Not Set ❌',
                    'resend_domain' => config('resend.domain') ?: 'Not Set',
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'config' => [
                    'mailer' => config('mail.default'),
                    'resend_api_key' => config('resend.api_key') ? 'Set ✅' : 'Not Set ❌',
                ]
            ], 500);
        }
    }

    public function debugOneSignalPush(\App\Services\OneSignalService $oneSignal)
    {
        $status = $oneSignal->isConfigured();
        if (!$status) {
            return response()->json([
                'status' => 'warning',
                'message' => 'OneSignal is not configured yet. Add ONESIGNAL_APP_ID and ONESIGNAL_REST_API_KEY in .env.',
                'config' => [
                    'app_id' => config('onesignal.app_id') ? 'Set ✅' : 'Not Set ❌',
                    'rest_api_key' => config('onesignal.rest_api_key') ? 'Set ✅' : 'Not Set ❌',
                    'safari_web_id' => config('onesignal.safari_web_id') ?: 'Not Set',
                ]
            ]);
        }

        $result = $oneSignal->sendPushToAll(
            '🔔 AnywhereRoles Test Notification',
            'This is a live test push notification from AnywhereRoles debug suite!',
            url('/')
        );

        return response()->json([
            'status' => $result['success'] ? 'success' : 'error',
            'result' => $result,
            'config' => [
                'app_id' => config('onesignal.app_id'),
            ]
        ], $result['success'] ? 200 : 400);
    }

    public function debugOneSignalEmail(string $email, \App\Services\OneSignalService $oneSignal)
    {
        $status = $oneSignal->isConfigured();
        if (!$status) {
            return response()->json([
                'status' => 'warning',
                'message' => 'OneSignal is not configured yet. Add ONESIGNAL_APP_ID and ONESIGNAL_REST_API_KEY in .env.',
            ]);
        }

        $result = $oneSignal->sendEmailToExternalUsers(
            $email,
            '✅ OneSignal Email Test - AnywhereRoles',
            '<h2>OneSignal Email Test</h2><p>This test email confirms OneSignal email sending is functioning properly.</p>'
        );

        return response()->json([
            'status' => $result['success'] ? 'success' : 'error',
            'result' => $result,
        ], $result['success'] ? 200 : 400);
    }
}

