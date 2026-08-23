<?php

namespace App\Notifications\Messages;

class OneSignalMessage
{
    public ?string $title = null;
    public ?string $body = null;
    public ?string $url = null;
    public ?string $image = null;
    public ?string $icon = null;
    public ?string $badge = null;
    public array $data = [];
    public array $buttons = [];
    public string $targetChannel = 'push'; // 'push' or 'email'
    public ?array $segments = null;

    // Email specific properties
    public ?string $emailSubject = null;
    public ?string $emailBody = null;
    public ?string $emailFromName = null;
    public ?string $emailFromAddress = null;
    public ?string $templateId = null;

    public static function create(?string $body = null): static
    {
        $instance = new static();
        if ($body !== null) {
            $instance->body($body);
        }
        return $instance;
    }

    public function title(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function body(string $body): static
    {
        $this->body = $body;
        return $this;
    }

    public function message(string $message): static
    {
        return $this->body($message);
    }

    public function url(string $url): static
    {
        $this->url = $url;
        return $this;
    }

    public function image(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function badge(string $badge): static
    {
        $this->badge = $badge;
        return $this;
    }

    public function data(array $data): static
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    public function button(string $id, string $text, ?string $icon = null, ?string $url = null): static
    {
        $this->buttons[] = array_filter([
            'id' => $id,
            'text' => $text,
            'icon' => $icon,
            'url' => $url,
        ]);
        return $this;
    }

    public function toPush(): static
    {
        $this->targetChannel = 'push';
        return $this;
    }

    public function toEmail(): static
    {
        $this->targetChannel = 'email';
        return $this;
    }

    public function segments(array $segments): static
    {
        $this->segments = $segments;
        return $this;
    }

    public function emailSubject(string $subject): static
    {
        $this->emailSubject = $subject;
        return $this;
    }

    public function emailBody(string $html): static
    {
        $this->emailBody = $html;
        return $this;
    }

    public function emailFrom(string $address, ?string $name = null): static
    {
        $this->emailFromAddress = $address;
        if ($name) {
            $this->emailFromName = $name;
        }
        return $this;
    }

    public function template(string $templateId): static
    {
        $this->templateId = $templateId;
        return $this;
    }
}
