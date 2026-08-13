<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public string $verificationUrl
    ) {
    }

    public function build()
    {
        return $this->subject('Verifikasi Alamat Email')
            ->markdown('emails.auth.verify-email');
    }
}
