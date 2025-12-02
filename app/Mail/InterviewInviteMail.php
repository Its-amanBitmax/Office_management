<?php

namespace App\Mail;

use App\Models\Interview;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $interview;

    public function __construct(Interview $interview)
    {
        $this->interview = $interview;
    }

    public function build()
    {
        return $this->from(
                config('mail.hr_from.address'),
                config('mail.hr_from.name')
            )
            ->subject('Interview Invitation – Bitmax Group')
            ->view('emails.interview_invite');
    }
}
