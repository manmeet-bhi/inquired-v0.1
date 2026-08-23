<?php

namespace App\Notifications\Channels;

use App\Notifications\Messages\OneSignalMessage;
use App\Services\OneSignalService;
use Illuminate\Notifications\Notification;

class OneSignalChannel
{
    protected OneSignalService $oneSignal;

    public function __construct(OneSignalService $oneSignal)
    {
        $this->oneSignal = $oneSignal;
    }

    /**
     * Send the given notification.
     */
    public function send(mixed $notifiable, Notification $notification): ?array
    {
        if (!method_exists($notification, 'toOneSignal')) {
            return null;
        }

        /** @var OneSignalMessage|array|string $message */
        $message = $notification->toOneSignal($notifiable);

        if (is_string($message)) {
            $message = OneSignalMessage::create($message);
        } elseif (is_array($message)) {
            $msgObj = OneSignalMessage::create($message['body'] ?? $message['message'] ?? '');
            if (!empty($message['title'])) $msgObj->title($message['title']);
            if (!empty($message['url'])) $msgObj->url($message['url']);
            $message = $msgObj;
        }

        // If broadcast/segments are specified, send to segment directly
        if (!empty($message->segments)) {
            if ($message->targetChannel === 'email') {
                return $this->oneSignal->sendEmailToSegment(
                    $message->segments[0],
                    $message->emailSubject ?: ($message->title ?? 'Notification'),
                    $message->emailBody ?: ($message->body ?? ''),
                    [
                        'from_name' => $message->emailFromName,
                        'from_address' => $message->emailFromAddress,
                        'template_id' => $message->templateId,
                    ]
                );
            }

            return $this->oneSignal->sendPushToSegments(
                $message->segments,
                $message->title ?? config('app.name'),
                $message->body ?? '',
                $message->url,
                array_merge($message->data, [
                    'image' => $message->image,
                    'buttons' => $message->buttons,
                ])
            );
        }

        // Resolve external ID for notifiable
        $externalId = $this->resolveExternalId($notifiable, $notification);
        if (!$externalId) {
            return null;
        }

        if ($message->targetChannel === 'email') {
            return $this->oneSignal->sendEmailToExternalUsers(
                $externalId,
                $message->emailSubject ?: ($message->title ?? 'Notification'),
                $message->emailBody ?: ($message->body ?? ''),
                [
                    'from_name' => $message->emailFromName,
                    'from_address' => $message->emailFromAddress,
                    'template_id' => $message->templateId,
                    'data' => $message->data,
                ]
            );
        }

        return $this->oneSignal->sendPushToExternalUsers(
            $externalId,
            $message->title ?? config('app.name'),
            $message->body ?? '',
            $message->url,
            array_merge($message->data, [
                'image' => $message->image,
                'buttons' => $message->buttons,
            ])
        );
    }

    /**
     * Resolve external ID from notifiable entity.
     */
    protected function resolveExternalId(mixed $notifiable, Notification $notification): ?string
    {
        if (method_exists($notifiable, 'routeNotificationForOneSignal')) {
            return $notifiable->routeNotificationForOneSignal($notification);
        }

        if (method_exists($notifiable, 'routeNotificationFor')) {
            $routed = $notifiable->routeNotificationFor('OneSignal', $notification);
            if ($routed) return $routed;
        }

        if (isset($notifiable->external_id) && $notifiable->external_id) {
            return (string) $notifiable->external_id;
        }

        if (isset($notifiable->id)) {
            $prefix = ($notifiable instanceof \App\Models\AdminUser) ? 'admin_' : 'user_';
            return $prefix . $notifiable->id;
        }

        return null;
    }
}
