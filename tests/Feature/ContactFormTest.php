<?php

namespace Tests\Feature;

use App\Livewire\Public\ContactForm;
use App\Mail\ContactMessageMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_submission_emails_the_site_inbox(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->set('name', 'Ana Anić')
            ->set('email', 'ana@example.com')
            ->set('subject', 'Rođendanska proslava')
            ->set('participants', 20)
            ->set('eventDate', '24.08.2026')
            ->set('message', 'Zanima me organizacija rođendana za 20 osoba.')
            ->call('submit')
            ->assertSet('submitted', true);

        Mail::assertSent(ContactMessageMail::class, function (ContactMessageMail $mail) {
            return $mail->senderName === 'Ana Anić'
                && $mail->senderEmail === 'ana@example.com'
                && $mail->participants === 20
                && $mail->hasTo(config('site.contact.email'));
        });
    }

    public function test_required_fields_are_validated(): void
    {
        Mail::fake();

        Livewire::test(ContactForm::class)
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'subject', 'eventDate', 'message']);

        Mail::assertNothingSent();
    }
}
