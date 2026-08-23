<?php

namespace App\Console\Commands;

use App\Services\OneSignalService;
use Illuminate\Console\Command;

class OneSignalTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onesignal:test 
                            {type=status : Test type: status, push, or email}
                            {--title=Test Notification : Notification title}
                            {--message=This is a test notification from AnywhereRoles : Notification body}
                            {--url= : Landing URL}
                            {--user= : Target External User ID}
                            {--email= : Target Email address for email test}
                            {--segment=Total Subscriptions : Target segment for broadcast}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test OneSignal configuration and send test Web Push notifications or Emails';

    /**
     * Execute the console command.
     */
    public function handle(OneSignalService $oneSignal): int
    {
        $type = strtolower($this->argument('type'));

        $this->info('=============================================');
        $this->info('  OneSignal Configuration & Testing Tool     ');
        $this->info('=============================================');

        $appId = config('onesignal.app_id');
        $hasKey = !empty(config('onesignal.rest_api_key'));

        $this->line("App ID: " . ($appId ?: '<fg=red>Not configured</>'));
        $this->line("REST API Key: " . ($hasKey ? '<fg=green>Configured (Hidden)</>' : '<fg=red>Not configured</>'));
        $this->line("Safari Web ID: " . (config('onesignal.safari_web_id') ?: '<fg=yellow>None</>'));
        $this->newLine();

        if ($type === 'status') {
            if ($oneSignal->isConfigured()) {
                $this->info(' OneSignal is fully configured and ready to send notifications.');
            } else {
                $this->warn('! OneSignal credentials are missing. Please add ONESIGNAL_APP_ID and ONESIGNAL_REST_API_KEY to your .env file.');
            }
            return Command::SUCCESS;
        }

        if (!$oneSignal->isConfigured()) {
            $this->error('Cannot send test notification: ONESIGNAL_APP_ID and ONESIGNAL_REST_API_KEY must be set in your .env file.');
            return Command::FAILURE;
        }

        $title = $this->option('title');
        $message = $this->option('message');
        $url = $this->option('url') ?: config('app.url');
        $targetUser = $this->option('user');
        $targetEmail = $this->option('email');
        $segment = $this->option('segment');

        if ($type === 'push') {
            $this->info("Sending test Web Push notification...");
            
            if ($targetUser) {
                $this->line("Targeting External User: {$targetUser}");
                $result = $oneSignal->sendPushToExternalUsers($targetUser, $title, $message, $url);
            } else {
                $this->line("Targeting Segment: {$segment}");
                $result = $oneSignal->sendPushToSegments([$segment], $title, $message, $url);
            }

            if ($result['success']) {
                $this->info(' Push notification dispatched successfully!');
                $this->line("OneSignal Notification ID: " . ($result['id'] ?? 'N/A'));
                $this->line("Estimated Recipients: " . ($result['recipients'] ?? '0'));
                return Command::SUCCESS;
            }

            $this->error(' Failed to dispatch push notification: ' . ($result['error'] ?? 'Unknown error'));
            return Command::FAILURE;
        }

        if ($type === 'email') {
            $this->info("Sending test Email notification via OneSignal...");

            $htmlBody = "<h2>{$title}</h2><p>{$message}</p><p><a href='{$url}'>Visit Website</a></p>";

            if ($targetUser) {
                $this->line("Targeting External User: {$targetUser}");
                $result = $oneSignal->sendEmailToExternalUsers($targetUser, $title, $htmlBody);
            } else {
                $this->line("Targeting Segment: {$segment}");
                $result = $oneSignal->sendEmailToSegment($segment, $title, $htmlBody);
            }

            if ($result['success']) {
                $this->info(' Email notification dispatched successfully via OneSignal!');
                $this->line("OneSignal Notification ID: " . ($result['id'] ?? 'N/A'));
                return Command::SUCCESS;
            }

            $this->error(' Failed to send email via OneSignal: ' . ($result['error'] ?? 'Unknown error'));
            return Command::FAILURE;
        }

        $this->error("Unknown test type: [{$type}]. Supported types: status, push, email.");
        return Command::INVALID;
    }
}
