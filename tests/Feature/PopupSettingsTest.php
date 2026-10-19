<?php

namespace Tests\Feature;

use App\Filament\Pages\PopupSettingsPage;
use App\Models\PopupSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PopupSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_popup_is_hidden_when_offline_or_without_image(): void
    {
        $this->get('/hr')->assertDontSee('popup-', false);

        PopupSetting::current()->update(['is_active' => false, 'image_path' => 'popup/x.jpg']);
        $this->get('/hr')->assertDontSee('popup/x.jpg', false);

        PopupSetting::current()->update(['is_active' => true, 'image_path' => null]);
        $this->get('/hr')->assertDontSee('aria-modal', false);
    }

    public function test_online_popup_shows_image_and_link_on_every_locale(): void
    {
        PopupSetting::current()->update([
            'is_active' => true,
            'image_path' => 'popup/novagodina.jpg',
            'link_url' => '/hr/kontakt',
            'alt_text' => 'Doček Nove godine',
        ]);

        foreach (['hr', 'en', 'de'] as $locale) {
            $this->get("/{$locale}")
                ->assertSuccessful()
                ->assertSee('/storage/popup/novagodina.jpg', false)
                ->assertSee('href="/hr/kontakt"', false)
                ->assertSee('Doček Nove godine');
        }
    }

    public function test_admin_can_upload_image_and_toggle_online(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        $this->get('/admin/popup')->assertSuccessful();

        Livewire::test(PopupSettingsPage::class)
            ->set('data.is_active', true)
            ->set('data.image_path', [UploadedFile::fake()->image('novagodina.jpg', 1024, 1536)])
            ->call('save')
            ->assertHasNoErrors();

        $popup = PopupSetting::current();
        $this->assertTrue($popup->is_active);
        Storage::disk('public')->assertExists($popup->image_path);

        Livewire::test(PopupSettingsPage::class)->set('data.is_active', false)->call('save');
        $this->assertFalse(PopupSetting::current()->is_active);
    }

    public function test_online_popup_requires_an_image(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));

        Livewire::test(PopupSettingsPage::class)
            ->set('data.is_active', true)
            ->set('data.image_path', [])
            ->call('save')
            ->assertHasErrors(['data.image_path']);
    }

    public function test_reservation_staff_cannot_manage_popup(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'reservation_staff']));

        $this->get('/admin/popup')->assertForbidden();
    }
}
