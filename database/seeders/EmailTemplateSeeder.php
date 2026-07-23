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
                'subject' => 'We received your booking request - {{house_name}}',
                'body' => '<p>Hi {{guest_name}},</p><p>We received your reservation request for {{house_name}} from {{check_in}} to {{check_out}}. We will confirm availability shortly.</p><p>Estimated total: {{total_price}}</p>',
            ],
            [
                'key' => 'guest_confirmed',
                'recipient' => 'guest',
                'subject' => 'Your reservation is confirmed - {{house_name}}',
                'body' => '<p>Hi {{guest_name}},</p><p>Your reservation #{{reservation_id}} for {{house_name}} ({{check_in}} - {{check_out}}) is confirmed.</p><p>Total: {{total_price}}</p>',
            ],
            [
                'key' => 'guest_rejected',
                'recipient' => 'guest',
                'subject' => 'Update on your reservation request - {{house_name}}',
                'body' => '<p>Hi {{guest_name}},</p><p>Unfortunately we are unable to accept your reservation request for {{house_name}} ({{check_in}} - {{check_out}}).</p>',
            ],
            [
                'key' => 'guest_modified',
                'recipient' => 'guest',
                'subject' => 'Your reservation has been updated - {{house_name}}',
                'body' => '<p>Hi {{guest_name}},</p><p>Your reservation #{{reservation_id}} has been updated. New dates: {{check_in}} - {{check_out}}. Total: {{total_price}}</p>',
            ],
            [
                'key' => 'guest_cancelled',
                'recipient' => 'guest',
                'subject' => 'Your reservation has been cancelled - {{house_name}}',
                'body' => '<p>Hi {{guest_name}},</p><p>Your reservation #{{reservation_id}} for {{house_name}} has been cancelled.</p>',
            ],
            [
                'key' => 'guest_reminder',
                'recipient' => 'guest',
                'subject' => 'See you soon at {{house_name}}!',
                'body' => '<p>Hi {{guest_name}},</p><p>This is a reminder that your stay at {{house_name}} starts on {{check_in}}. We look forward to welcoming you!</p>',
            ],
            [
                'key' => 'guest_post_stay',
                'recipient' => 'guest',
                'subject' => 'Thank you for staying at {{house_name}}',
                'body' => '<p>Hi {{guest_name}},</p><p>Thank you for staying with us at {{house_name}}. We hope you enjoyed your visit!</p>',
            ],
            [
                'key' => 'admin_new_request',
                'recipient' => 'admin',
                'subject' => 'New reservation request - {{house_name}}',
                'body' => '<p>New request #{{reservation_id}} for {{house_name}} ({{check_in}} - {{check_out}}) from {{guest_name}}.</p>',
            ],
            [
                'key' => 'admin_cancelled',
                'recipient' => 'admin',
                'subject' => 'Reservation cancelled - {{house_name}}',
                'body' => '<p>Reservation #{{reservation_id}} for {{house_name}} ({{check_in}} - {{check_out}}) was cancelled.</p>',
            ],
            [
                'key' => 'admin_arrival_reminder',
                'recipient' => 'admin',
                'subject' => 'Upcoming arrival - {{house_name}}',
                'body' => '<p>Reminder: {{guest_name}} arrives at {{house_name}} on {{check_in}}.</p>',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['key' => $template['key']],
                [
                    'recipient' => $template['recipient'],
                    'subject' => ['en' => $template['subject']],
                    'body' => ['en' => $template['body']],
                    'is_active' => true,
                ]
            );
        }
    }
}
