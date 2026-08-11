<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'key' => 'guest_request_received',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Zaprimili smo vaš upit za rezervaciju - {{house_name}}',
                    'en' => "We've received your reservation request - {{house_name}}",
                    'de' => 'Wir haben Ihre Reservierungsanfrage erhalten - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Hvala vam što ste odabrali Kopić Land! Zaprimili smo vaš upit za rezervaciju kućice <strong>{{house_name}}</strong> u terminu od <strong>{{check_in}}</strong> do <strong>{{check_out}}</strong>.</p><p>Provjerit ćemo dostupnost i uskoro se javiti s potvrdom.</p><p>Procijenjeni ukupni iznos: <strong>{{total_price}}</strong></p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Thank you for choosing Kopić Land! We\'ve received your reservation request for <strong>{{house_name}}</strong> from <strong>{{check_in}}</strong> to <strong>{{check_out}}</strong>.</p><p>We\'ll check availability and get back to you shortly with a confirmation.</p><p>Estimated total: <strong>{{total_price}}</strong></p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>vielen Dank, dass Sie sich für Kopić Land entschieden haben! Wir haben Ihre Reservierungsanfrage für <strong>{{house_name}}</strong> vom <strong>{{check_in}}</strong> bis <strong>{{check_out}}</strong> erhalten.</p><p>Wir prüfen die Verfügbarkeit und melden uns in Kürze mit einer Bestätigung.</p><p>Geschätzter Gesamtbetrag: <strong>{{total_price}}</strong></p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_pending',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Vaša rezervacija čeka uplatu - {{house_name}}',
                    'en' => 'Your reservation is pending payment - {{house_name}}',
                    'de' => 'Ihre Reservierung wartet auf Zahlung - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Vaša rezervacija je trenutno na čekanju za uplatu.</p><p>Odabrani datumi su potvrđeni i rezervirani za Vas. Za konačnu potvrdu rezervacije potrebno je izvršiti uplatu za odabrani period.</p><p>Plaćanje možete izvršiti na jedan od sljedećih načina:</p><p><strong>INTERNET BANKARSTVO</strong></p><p>OTP banka<br>IBAN: HR4824070001100775365<br>Opis plaćanja: Rezervacija #{{reservation_id}}</p><p>Molimo Vas da prilikom plaćanja obavezno navedete broj rezervacije u opisu plaćanja kako bismo uplatu mogli povezati s Vašom rezervacijom.</p><p><strong>SLIKAJ I PLATI</strong></p><p>Za brzo i jednostavno plaćanje skenirajte priloženi QR kod putem aplikacije mobilnog bankarstva.</p><p><strong>PLAĆANJE PRILIKOM DOLASKA</strong></p><p>Plaćanje je moguće i prilikom dolaska:</p><ul><li>gotovinom</li><li>bankovnim karticama putem POS uređaja</li></ul><p>Nakon evidentirane uplate ili izvršenog plaćanja primit ćete potvrdu rezervacije.</p><p>Hvala Vam na rezervaciji i veselimo se Vašem dolasku!</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Dear {{guest_name}},</p><p>Your reservation is currently pending payment.</p><p>The selected dates have been confirmed and reserved for you. To finalize your reservation, payment for the selected period is required.</p><p>You can make the payment using one of the following methods:</p><p><strong>ONLINE BANKING</strong></p><p>OTP banka<br>IBAN: HR4824070001100775365<br>Payment description: Reservation #{{reservation_id}}</p><p>Please make sure to include the reservation number in the payment description so we can match your payment to your reservation.</p><p><strong>SCAN &amp; PAY</strong></p><p>For quick and easy payment, scan the attached QR code using your mobile banking app.</p><p><strong>PAYMENT ON ARRIVAL</strong></p><p>Payment is also possible upon arrival:</p><ul><li>cash</li><li>bank card via POS terminal</li></ul><p>Once your payment has been received, you will receive your reservation confirmation.</p><p>Thank you for your reservation, we look forward to welcoming you!</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>Ihre Reservierung wartet derzeit auf die Zahlung.</p><p>Die ausgewählten Termine wurden für Sie bestätigt und reserviert. Zur endgültigen Bestätigung der Reservierung ist eine Zahlung für den gewählten Zeitraum erforderlich.</p><p>Die Zahlung können Sie auf eine der folgenden Arten vornehmen:</p><p><strong>ONLINE-BANKING</strong></p><p>OTP banka<br>IBAN: HR4824070001100775365<br>Zahlungsbeschreibung: Reservierung #{{reservation_id}}</p><p>Bitte geben Sie bei der Zahlung unbedingt die Reservierungsnummer in der Zahlungsbeschreibung an, damit wir die Zahlung Ihrer Reservierung zuordnen können.</p><p><strong>SCANNEN &amp; BEZAHLEN</strong></p><p>Für eine schnelle und einfache Zahlung scannen Sie den beigefügten QR-Code mit Ihrer Mobile-Banking-App.</p><p><strong>ZAHLUNG BEI ANKUNFT</strong></p><p>Die Zahlung ist auch bei Ankunft möglich:</p><ul><li>bar</li><li>mit Bankkarte über das POS-Terminal</li></ul><p>Nach Eingang der Zahlung erhalten Sie Ihre Reservierungsbestätigung.</p><p>Vielen Dank für Ihre Reservierung, wir freuen uns auf Ihren Besuch!</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_confirmed',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Vaša rezervacija je potvrđena - {{house_name}}',
                    'en' => 'Your reservation is confirmed - {{house_name}}',
                    'de' => 'Ihre Reservierung ist bestätigt - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Sjajne vijesti — vaša rezervacija <strong>#{{reservation_id}}</strong> za <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) je potvrđena!</p><p>Ukupan iznos: <strong>{{total_price}}</strong></p><p>Veselimo se vašem dolasku.</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Great news — your reservation <strong>#{{reservation_id}}</strong> for <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) is confirmed!</p><p>Total: <strong>{{total_price}}</strong></p><p>We look forward to welcoming you.</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>gute Neuigkeiten — Ihre Reservierung <strong>#{{reservation_id}}</strong> für <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) ist bestätigt!</p><p>Gesamtbetrag: <strong>{{total_price}}</strong></p><p>Wir freuen uns auf Sie.</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_rejected',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Informacija o vašem upitu za rezervaciju - {{house_name}}',
                    'en' => 'Update on your reservation request - {{house_name}}',
                    'de' => 'Update zu Ihrer Reservierungsanfrage - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Hvala vam na interesu za <strong>{{house_name}}</strong>. Nažalost, trenutačno nismo u mogućnosti prihvatiti vaš upit za termin <strong>{{check_in}} - {{check_out}}</strong>.</p><p>Rado ćemo vam pomoći pronaći neki drugi slobodan termin — slobodno nas kontaktirajte.</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Thank you for your interest in <strong>{{house_name}}</strong>. Unfortunately, we\'re unable to accept your reservation request for <strong>{{check_in}} - {{check_out}}</strong> at this time.</p><p>We\'d be happy to help you find another available date — feel free to get in touch.</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>vielen Dank für Ihr Interesse an <strong>{{house_name}}</strong>. Leider können wir Ihre Reservierungsanfrage für <strong>{{check_in}} - {{check_out}}</strong> derzeit nicht annehmen.</p><p>Gerne helfen wir Ihnen, einen anderen freien Termin zu finden — kontaktieren Sie uns einfach.</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_modified',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Vaša rezervacija je izmijenjena - {{house_name}}',
                    'en' => 'Your reservation has been updated - {{house_name}}',
                    'de' => 'Ihre Reservierung wurde geändert - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Vaša rezervacija <strong>#{{reservation_id}}</strong> za <strong>{{house_name}}</strong> je izmijenjena.</p><p>Novi datumi: <strong>{{check_in}} - {{check_out}}</strong><br>Ukupno: <strong>{{total_price}}</strong></p><p>Ako imate pitanja, slobodno odgovorite na ovaj e-mail.</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Your reservation <strong>#{{reservation_id}}</strong> for <strong>{{house_name}}</strong> has been updated.</p><p>New dates: <strong>{{check_in}} - {{check_out}}</strong><br>Total: <strong>{{total_price}}</strong></p><p>If you have any questions, just reply to this email.</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>Ihre Reservierung <strong>#{{reservation_id}}</strong> für <strong>{{house_name}}</strong> wurde aktualisiert.</p><p>Neue Daten: <strong>{{check_in}} - {{check_out}}</strong><br>Gesamtbetrag: <strong>{{total_price}}</strong></p><p>Bei Fragen antworten Sie einfach auf diese E-Mail.</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_cancelled',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Vaša rezervacija je otkazana - {{house_name}}',
                    'en' => 'Your reservation has been cancelled - {{house_name}}',
                    'de' => 'Ihre Reservierung wurde storniert - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Vaša rezervacija <strong>#{{reservation_id}}</strong> za <strong>{{house_name}}</strong> je otkazana.</p><p>Ako ovo niste očekivali ili biste željeli napraviti novu rezervaciju, slobodno nas kontaktirajte.</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Your reservation <strong>#{{reservation_id}}</strong> for <strong>{{house_name}}</strong> has been cancelled.</p><p>If this wasn\'t expected or you\'d like to make a new booking, please get in touch with us.</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>Ihre Reservierung <strong>#{{reservation_id}}</strong> für <strong>{{house_name}}</strong> wurde storniert.</p><p>Falls dies unerwartet kam oder Sie eine neue Buchung vornehmen möchten, kontaktieren Sie uns gerne.</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_reminder',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Vidimo se uskoro u {{house_name}}!',
                    'en' => 'See you soon at {{house_name}}!',
                    'de' => 'Bis bald in {{house_name}}!',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Ovo je prijateljski podsjetnik da vaš boravak u <strong>{{house_name}}</strong> počinje <strong>{{check_in}}</strong>.</p><p>Veselimo se vašem dolasku!</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Just a friendly reminder that your stay at <strong>{{house_name}}</strong> starts on <strong>{{check_in}}</strong>.</p><p>We look forward to welcoming you soon!</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>nur eine kurze Erinnerung: Ihr Aufenthalt in <strong>{{house_name}}</strong> beginnt am <strong>{{check_in}}</strong>.</p><p>Wir freuen uns schon auf Sie!</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'guest_post_stay',
                'recipient' => 'guest',
                'subject' => [
                    'hr' => 'Hvala vam što ste odsjeli u {{house_name}}',
                    'en' => 'Thank you for staying at {{house_name}}',
                    'de' => 'Danke für Ihren Aufenthalt in {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Poštovani/a {{guest_name}},</p><p>Hvala vam što ste odsjeli kod nas u <strong>{{house_name}}</strong>. Nadamo se da ste uživali i veselimo se vašem ponovnom dolasku!</p><p>Srdačan pozdrav,<br>Kopić Land</p>',
                    'en' => '<p>Hi {{guest_name}},</p><p>Thank you for staying with us at <strong>{{house_name}}</strong>. We hope you had a wonderful time and hope to welcome you back again soon!</p><p>Best regards,<br>Kopić Land</p>',
                    'de' => '<p>Hallo {{guest_name}},</p><p>vielen Dank, dass Sie bei uns in <strong>{{house_name}}</strong> übernachtet haben. Wir hoffen, Sie hatten eine schöne Zeit, und freuen uns, Sie bald wieder begrüßen zu dürfen!</p><p>Herzliche Grüße,<br>Kopić Land</p>',
                ],
            ],
            [
                'key' => 'admin_new_request',
                'recipient' => 'admin',
                'subject' => [
                    'hr' => 'Novi upit za rezervaciju - {{house_name}}',
                    'en' => 'New reservation request - {{house_name}}',
                    'de' => 'Neue Reservierungsanfrage - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Novi upit <strong>#{{reservation_id}}</strong> za <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) od {{guest_name}}.</p>',
                    'en' => '<p>New request <strong>#{{reservation_id}}</strong> for <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) from {{guest_name}}.</p>',
                    'de' => '<p>Neue Anfrage <strong>#{{reservation_id}}</strong> für <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) von {{guest_name}}.</p>',
                ],
            ],
            [
                'key' => 'admin_cancelled',
                'recipient' => 'admin',
                'subject' => [
                    'hr' => 'Rezervacija otkazana - {{house_name}}',
                    'en' => 'Reservation cancelled - {{house_name}}',
                    'de' => 'Reservierung storniert - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Rezervacija <strong>#{{reservation_id}}</strong> za <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) je otkazana.</p>',
                    'en' => '<p>Reservation <strong>#{{reservation_id}}</strong> for <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) was cancelled.</p>',
                    'de' => '<p>Reservierung <strong>#{{reservation_id}}</strong> für <strong>{{house_name}}</strong> ({{check_in}} - {{check_out}}) wurde storniert.</p>',
                ],
            ],
            [
                'key' => 'admin_arrival_reminder',
                'recipient' => 'admin',
                'subject' => [
                    'hr' => 'Nadolazeći dolazak - {{house_name}}',
                    'en' => 'Upcoming arrival - {{house_name}}',
                    'de' => 'Bevorstehende Ankunft - {{house_name}}',
                ],
                'body' => [
                    'hr' => '<p>Podsjetnik: {{guest_name}} dolazi u <strong>{{house_name}}</strong> dana <strong>{{check_in}}</strong>.</p>',
                    'en' => '<p>Reminder: {{guest_name}} arrives at <strong>{{house_name}}</strong> on <strong>{{check_in}}</strong>.</p>',
                    'de' => '<p>Erinnerung: {{guest_name}} kommt am <strong>{{check_in}}</strong> in <strong>{{house_name}}</strong> an.</p>',
                ],
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['key' => $template['key']],
                [
                    'recipient' => $template['recipient'],
                    'subject' => $template['subject'],
                    'body' => $template['body'],
                    'is_active' => true,
                ]
            );
        }
    }
}
