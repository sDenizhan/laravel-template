<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendngEmailForMedicalForm extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     */
    public function __construct($inquiry, $subject, $message)
    {
        $this->inquiry = $inquiry;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function build()
    {
        return $this->view('themes.backend.default.email_templates.medicalform-mail-template')
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($this->subject)
            ->with([
                'subject' => $this->subject,
                'messageContent' => $this->message,
                'inquiry' => $this->inquiry,
            ]);
    }

}
