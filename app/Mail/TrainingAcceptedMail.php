<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TrainingAcceptedMail extends Mailable implements ShouldQueue
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
        return $this->subject('Pendaftaran Pelatihan Diterima')
            ->markdown('emails.training.accepted');
    }
}
