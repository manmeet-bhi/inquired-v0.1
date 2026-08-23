<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    protected ?string $appId;
    protected ?string $restApiKey;
    protected string $apiUrl;
    protected int $timeout;
    protected ?string $defaultIcon;
    protected ?string $defaultBadge;
    protected ?string $defaultUrl;
    protected ?string $emailFromName;
    protected ?string $emailFromAddress;

    public function __construct()
    {
        $this->appId = config('onesignal.app_id');
        $this->restApiKey = config('onesignal.rest_api_key');
        $this->apiUrl = rtrim(config('onesignal.api_url', 'https://onesignal.com/api/v1'), '/');
        $this->timeout = (int) config('onesignal.timeout', 15);
        $this->defaultIcon = config('onesignal.defaults.icon');
        $this->defaultBadge = config('onesignal.defaults.badge');
        $this->defaultUrl = config('onesignal.defaults.url');
        $this->emailFromName = config('onesignal.email.from_name');
        $this->emailFromAddress = config('onesignal.email.from_address');
    }

    /**
     * Check if OneSignal credentials are configured.
     */
    public function isConfigured(): bool
    {
        return !empty($this->appId) && !empty($this->restApiKey);
    }

    /**
     * Send Web Push notification to all active subscribers.
     */
    public function sendPushToAll(string $title, string $message, ?string $url = null, array $extra = []): array
    {
        return $this->sendPushToSegments(['Total Subscriptions'], $title, $message, $url, $extra);
    }

    /**
     * Send Web Push notification to specific segment(s).
     */
    public function sendPushToSegments(array $segments, string $title, string $message, ?string $url = null, array $extra = []): array
    {
        $payload = [
            'included_segments' => $segments,
            'headings' => ['en' => $title],
            'contents' => ['en' => $message],
            'target_channel' => 'push',
        ];

        return $this->dispatchPushNotification($payload, $url, $extra);
    }

    /**
     * Send Web Push notification to specific user(s) by External ID.
     */
    public function sendPushToExternalUsers(array|string $externalIds, string $title, string $message, ?string $url = null, array $extra = []): array
    {
        $ids = is_array($externalIds) ? array_values($externalIds) : [$externalIds];

        $payload = [
            'include_aliases' => [
                'external_id' => $ids,
            ],
            'include_external_user_ids' => $ids, // Fallback compatibility for older OneSignal API specs
            'headings' => ['en' => $title],
            'contents' => ['en' => $message],
            'target_channel' => 'push',
        ];

        return $this->dispatchPushNotification($payload, $url, $extra);
    }

    /**
     * Send Web Push notification to specific subscription ID(s).
     */
    public function sendPushToSubscriptionIds(array|string $subscriptionIds, string $title, string $message, ?string $url = null, array $extra = []): array
    {
        $ids = is_array($subscriptionIds) ? array_values($subscriptionIds) : [$subscriptionIds];

        $payload = [
            'include_subscription_ids' => $ids,
            'headings' => ['en' => $title],
            'contents' => ['en' => $message],
            'target_channel' => 'push',
        ];

        return $this->dispatchPushNotification($payload, $url, $extra);
    }

    /**
     * Helper to prepare common push payload options and dispatch to API.
     */
    protected function dispatchPushNotification(array $payload, ?string $url = null, array $extra = []): array
    {
        $targetUrl = $url ?: $this->defaultUrl;
        if ($targetUrl) {
            $payload['url'] = $targetUrl;
        }

        if ($this->defaultIcon) {
            $payload['chrome_web_icon'] = url($this->defaultIcon);
            $payload['firefox_icon'] = url($this->defaultIcon);
        }

        if ($this->defaultBadge) {
            $payload['chrome_web_badge'] = url($this->defaultBadge);
        }

        if (!empty($extra['image'])) {
            $payload['chrome_web_image'] = $extra['image'];
            unset($extra['image']);
        }

        if (!empty($extra['buttons'])) {
            $payload['web_buttons'] = $extra['buttons'];
            unset($extra['buttons']);
        }

        if (!empty($extra)) {
            $payload['data'] = $extra;
        }

        return $this->sendNotification($payload);
    }

    /**
     * Send Email via OneSignal to specific External User ID(s).
     */
    public function sendEmailToExternalUsers(array|string $externalIds, string $subject, string $htmlBody, array $options = []): array
    {
        $ids = is_array($externalIds) ? array_values($externalIds) : [$externalIds];

        $payload = [
            'include_aliases' => [
                'external_id' => $ids,
            ],
            'include_external_user_ids' => $ids,
            'target_channel' => 'email',
            'email_subject' => $subject,
            'email_body' => $htmlBody,
            'email_from_name' => $options['from_name'] ?? $this->emailFromName,
            'email_from_address' => $options['from_address'] ?? $this->emailFromAddress,
        ];

        if (!empty($options['template_id'])) {
            $payload['template_id'] = $options['template_id'];
        }

        if (!empty($options['data'])) {
            $payload['custom_data'] = $options['data'];
        }

        return $this->sendNotification($payload);
    }

    /**
     * Send Email via OneSignal to a segment (e.g. Subscribed Users).
     */
    public function sendEmailToSegment(string $segment, string $subject, string $htmlBody, array $options = []): array
    {
        $payload = [
            'included_segments' => [$segment],
            'target_channel' => 'email',
            'email_subject' => $subject,
            'email_body' => $htmlBody,
            'email_from_name' => $options['from_name'] ?? $this->emailFromName,
            'email_from_address' => $options['from_address'] ?? $this->emailFromAddress,
        ];

        if (!empty($options['template_id'])) {
            $payload['template_id'] = $options['template_id'];
        }

        return $this->sendNotification($payload);
    }

    /**
     * Send raw notification payload to /api/v1/notifications.
     */
    public function sendNotification(array $payload): array
    {
        if (!$this->isConfigured()) {
            $errorMsg = 'OneSignal is not configured. Please set ONESIGNAL_APP_ID and ONESIGNAL_REST_API_KEY in .env.';
            Log::warning('[OneSignal] ' . $errorMsg);
            return [
                'success' => false,
                'id' => null,
                'recipients' => 0,
                'error' => $errorMsg,
                'data' => [],
            ];
        }

        $payload['app_id'] = $this->appId;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . $this->restApiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->timeout($this->timeout)
            ->post("{$this->apiUrl}/notifications", $payload);

            $data = $response->json() ?? [];

            if ($response->successful()) {
                return [
                    'success' => true,
                    'id' => $data['id'] ?? null,
                    'recipients' => $data['recipients'] ?? (isset($data['external_id']) && $data['external_id'] ? count((array) $data['external_id']) : 0),
                    'data' => $data,
                    'error' => null,
                ];
            }

            $errorMessage = $data['errors'][0] ?? $response->body() ?? 'Unknown OneSignal error';
            Log::error('[OneSignal] Notification API request failed: ' . $errorMessage, [
                'status' => $response->status(),
                'response' => $data,
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'id' => null,
                'recipients' => 0,
                'error' => $errorMessage,
                'data' => $data,
            ];
        } catch (\Throwable $e) {
            Log::error('[OneSignal] HTTP Exception: ' . $e->getMessage(), [
                'exception' => $e,
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'id' => null,
                'recipients' => 0,
                'error' => $e->getMessage(),
                'data' => [],
            ];
        }
    }

    /**
     * Create or update a user identity in OneSignal.
     */
    public function syncUser(string $externalId, array $properties = []): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'OneSignal not configured'];
        }

        try {
            $payload = [
                'properties' => $properties,
                'identity' => [
                    'external_id' => $externalId,
                ],
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Key ' . $this->restApiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout($this->timeout)
            ->post("{$this->apiUrl}/apps/{$this->appId}/users", $payload);

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
            ];
        } catch (\Throwable $e) {
            Log::error('[OneSignal] Sync User failed: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Associate an email subscription with an external user.
     */
    public function addEmailToUser(string $externalId, string $email): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'error' => 'OneSignal not configured'];
        }

        try {
            $payload = [
                'subscription' => [
                    'type' => 'Email',
                    'token' => $email,
                    'enabled' => true,
                ],
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Key ' . $this->restApiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout($this->timeout)
            ->post("{$this->apiUrl}/apps/{$this->appId}/users/by/external_id/{$externalId}/subscriptions", $payload);

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
            ];
        } catch (\Throwable $e) {
            Log::error('[OneSignal] Add Email to User failed: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
