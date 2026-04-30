<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $training;
    public $registrationNumber;

    public function __construct($user, $training, $registrationNumber)
    {
        $this->user = $user;
        $this->training = $training;
        $this->registrationNumber = $registrationNumber;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Pelatihan Berhasil')
                    ->markdown('emails.training.registration');
    }
}
