<?php

namespace Tests\Feature;

use App\Models\AcademicProgram;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdmissionsPopupTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_popup_content_and_it_appears_on_public_pages(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.admissions-popup.edit'))
            ->assertOk()
            ->assertSee('Admissions Popup Content')
            ->assertSee('type="radio"', false)
            ->assertSee('name="admissions_popup_is_active"', false)
            ->assertSee('Academic Session')
            ->assertSee('Manage Programs')
            ->assertSee('Add a program')
            ->assertSee('Active')
            ->assertSee('Inactive');

        AcademicProgram::query()->create([
            'title' => 'Doctor of Pharmacy',
            'slug' => 'doctor-of-pharmacy',
            'icon_label' => 'Rx',
            'accent' => 'sky',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        AcademicProgram::query()->create([
            'title' => 'Hidden Program',
            'slug' => 'hidden-program',
            'icon_label' => 'HP',
            'accent' => 'sky',
            'sort_order' => 2,
            'is_active' => false,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.admissions-popup.edit'))
            ->assertOk()
            ->assertSee('Doctor of Pharmacy')
            ->assertSee('Hidden Program');

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Hidden Program');

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Admissions Popup')
            ->assertSee('Manage popup');

        $this->actingAs($admin)
            ->put(route('admin.admissions-popup.update'), [
                'admissions_popup_is_active' => '1',
                'admissions_popup_eyebrow' => 'Applications now open',
                'admissions_popup_heading' => 'Begin your pharmacy journey',
                'admissions_popup_body' => 'Learn through practice and purpose.',
                'admissions_popup_button_label' => 'Start application',
                'admissions_popup_button_url' => 'https://admissions.example.test/apply',
                'admissions_popup_image_path' => null,
                'admissions_popup_session' => '2026-27',
            ])
            ->assertRedirect(route('admin.admissions-popup.edit'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('site_settings', [
            'admissions_popup_is_active' => true,
            'admissions_popup_eyebrow' => 'Applications now open',
            'admissions_popup_heading' => 'Begin your pharmacy journey',
            'admissions_popup_button_label' => 'Start application',
            'admissions_popup_button_url' => 'https://admissions.example.test/apply',
            'admissions_popup_session' => '2026-27',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Begin your pharmacy journey')
            ->assertSee('Start application')
            ->assertSee('https://admissions.example.test/apply')
            ->assertSee('2026-27')
            ->assertSee('Programs open for admission')
            ->assertSee('Doctor of Pharmacy')
            ->assertDontSee('Hidden Program')
            ->assertDontSee('admissions-popup__art-mark', false)
            ->assertSee('data-admissions-popup', false)
            ->assertDontSee('scps-admissions-popup-dismissed');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('data-admissions-popup', false);
    }

    public function test_inactive_popup_is_hidden_from_public_pages(): void
    {
        SiteSetting::query()->create([
            ...SiteSetting::defaults(),
            'admissions_popup_is_active' => false,
            'admissions_popup_heading' => 'Hidden admissions notice',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('data-admissions-popup', false)
            ->assertDontSee('Hidden admissions notice');
    }

    public function test_active_popup_only_appears_on_the_homepage(): void
    {
        SiteSetting::query()->create([
            ...SiteSetting::defaults(),
            'admissions_popup_is_active' => true,
            'admissions_popup_heading' => 'Homepage-only admissions notice',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('data-admissions-popup', false)
            ->assertSee('Homepage-only admissions notice')
            ->assertSee('window.location.hash', false);

        $this->get(route('events.index'))
            ->assertOk()
            ->assertDontSee('data-admissions-popup', false)
            ->assertDontSee('Homepage-only admissions notice');
    }

    public function test_admin_can_create_update_publish_and_delete_admission_programs_from_popup_page(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.admissions-popup.programs.store'), [
                'title' => 'Doctor of Pharmacy',
                'slug' => '',
                'icon_label' => 'Rx',
                'accent' => 'sky',
                'sort_order' => 1,
                'description' => 'A practice-focused pharmacy degree.',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.admissions-popup.edit'))
            ->assertSessionHasNoErrors();

        $program = AcademicProgram::query()->where('title', 'Doctor of Pharmacy')->firstOrFail();

        $this->assertSame('doctor-of-pharmacy', $program->slug);
        $this->assertTrue($program->is_active);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Doctor of Pharmacy');

        $this->actingAs($admin)
            ->put(route('admin.admissions-popup.programs.update', $program), [
                'title' => 'Bachelor of Pharmacy',
                'slug' => 'bachelor-of-pharmacy',
                'icon_label' => 'BPharm',
                'accent' => 'teal',
                'sort_order' => 2,
                'description' => 'Updated program description.',
            ])
            ->assertRedirect(route('admin.admissions-popup.edit'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('academic_programs', [
            'id' => $program->id,
            'title' => 'Bachelor of Pharmacy',
            'slug' => 'bachelor-of-pharmacy',
            'is_active' => false,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Bachelor of Pharmacy');

        $this->actingAs($admin)
            ->put(route('admin.admissions-popup.programs.update', $program), [
                'title' => 'Bachelor of Pharmacy',
                'slug' => 'bachelor-of-pharmacy',
                'icon_label' => 'BPharm',
                'accent' => 'teal',
                'sort_order' => 2,
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.admissions-popup.edit'))
            ->assertSessionHasNoErrors();

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Bachelor of Pharmacy');

        $this->actingAs($admin)
            ->delete(route('admin.admissions-popup.programs.destroy', $program))
            ->assertRedirect(route('admin.admissions-popup.edit'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('academic_programs', ['id' => $program->id]);
    }
}
