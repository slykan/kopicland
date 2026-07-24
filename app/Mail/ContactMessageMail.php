<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly string $senderName,
        public readonly string $senderEmail,
        public readonly string $subjectLine,
        public readonly int $participants,
        public readonly string $eventDate,
        public readonly string $messageBody,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '['.config('site.name').'] '.$this->subjectLine,
            replyTo: [$this->senderEmail],
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.contact-message', [
                'senderName' => $this->senderName,
                'senderEmail' => $this->senderEmail,
                'subjectLine' => $this->subjectLine,
                'participants' => $this->participants,
                'eventDate' => $this->eventDate,
                'messageBody' => $this->messageBody,
            ])->render(),
        );
    }
}
