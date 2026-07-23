<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_every_resource(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get('/admin/houses')->assertSuccessful();
        $this->get('/admin/reservations')->assertSuccessful();
        $this->get('/admin/extra-costs')->assertSuccessful();
        $this->get('/admin/calendar')->assertSuccessful();
    }

    public function test_reservation_staff_cannot_access_content_or_pricing_resources(): void
    {
        $staff = User::factory()->create(['role' => 'reservation_staff']);
        $this->actingAs($staff);

        $this->get('/admin/reservations')->assertSuccessful();
        $this->get('/admin/guests')->assertSuccessful();
        $this->get('/admin/calendar')->assertSuccessful();

        $this->get('/admin/houses')->assertForbidden();
        $this->get('/admin/extra-costs')->assertForbidden();
        $this->get('/admin/discounts')->assertForbidden();
        $this->get('/admin/email-templates')->assertForbidden();
    }

    public function test_content_editor_cannot_access_reservations_or_financial_resources(): void
    {
        $editor = User::factory()->create(['role' => 'content_editor']);
        $this->actingAs($editor);

        $this->get('/admin/houses')->assertSuccessful();
        $this->get('/admin/amenities')->assertSuccessful();

        $this->get('/admin/reservations')->assertForbidden();
        $this->get('/admin/guests')->assertForbidden();
        $this->get('/admin/calendar')->assertForbidden();
        $this->get('/admin/extra-costs')->assertForbidden();
    }
}
