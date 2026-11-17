<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @param array<string, string|int> $inquiry */
    public function __construct(public readonly array $inquiry) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '['.config('site.name').'] Upit: '.$this->inquiry['house'].', '.$this->inquiry['check_in'].' – '.$this->inquiry['check_out'],
            replyTo: [$this->inquiry['email']],
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: view('emails.booking-inquiry', ['i' => $this->inquiry])->render(),
        );
    }
}
