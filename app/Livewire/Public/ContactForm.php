<?php

namespace App\Livewire\Public;

use App\Mail\ContactMessageMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('required|string|max:255')]
    public string $subject = '';

    #[Validate('required|integer|min:1')]
    public int $participants = 1;

    #[Validate('required|date')]
    public string $eventDate = '';

    #[Validate('required|string|max:5000')]
    public string $message = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $this->validate();

        Mail::to(config('site.contact.email'))->send(new ContactMessageMail(
            senderName: $this->name,
            senderEmail: $this->email,
            subjectLine: $this->subject,
            participants: $this->participants,
            eventDate: $this->eventDate,
            messageBody: $this->message,
        ));

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.public.contact-form');
    }
}
