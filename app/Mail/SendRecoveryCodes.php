<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRecoveryCodes extends Mailable
{
    use Queueable, SerializesModels;

    public $codes;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $codes)
    {
        $this->user = $user;
        $this->codes = $codes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your 2FA Backup Recovery Codes')
                    ->view('emails.recovery-codes');
    }
}
