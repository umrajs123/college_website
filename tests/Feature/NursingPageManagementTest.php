<?php

namespace Tests\Feature;

use App\Models\NursingPageSection;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NursingPageManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.url' => null,
            'database.connections.sqlite.database' => ':memory:',
            'session.driver' => 'array',
            'cache.default' => 'array',
        ]);
        DB::purge('sqlite');
        $this->assertSame('sqlite', DB::connection()->getDriverName());
        $this->assertSame(':memory:', DB::connection()->getDatabaseName());
        $this->artisan('migrate', ['--database' => 'sqlite', '--force' => true])->assertExitCode(0);
    }

    public function test_nursing_page_shows_active_college_content_and_hides_inactive_sections(): void
    {
        NursingPageSection::create([
            'section_type' => 'feature',
            'eyebrow' => 'Hidden feature',
            'title' => 'Unpublished content',
            'body' => 'This must not appear on the public page.',
            'sort_order' => 20,
            'is_active' => false,
        ]);

        $this->get(route('nursing.index'))
            ->assertOk()
            ->assertSee('Care begins with a calling.')
            ->assertSee('nursing-hero__stethoscope', false)
            ->assertSee('The Nursing College at SCPS')
            ->assertSee('Knowledge with compassion')
            ->assertSee('Communication builds trust')
            ->assertSee('Safety lives in the details')
            ->assertSee('Stronger together')
            ->assertSee('data-icon="heart"', false)
            ->assertSee('data-icon="stethoscope"', false)
            ->assertSee('data-icon="spark"', false)
            ->assertSee('data-icon="people"', false)
            ->assertSee('data-icon="shield"', false)
            ->assertSee('data-icon="pulse"', false)
            ->assertSee('nursing-feature-icon--red', false)
            ->assertSee('See the person, not only the condition.')
            ->assertSee('Listen closely')
            ->assertDontSee('Unpublished content');
    }

    public function test_nursing_page_displays_local_care_and_college_photos(): void
    {
        $this->get(route('nursing.index'))
            ->assertOk()
            ->assertSee(asset('images/nursing-care.jpg'))
            ->assertSee(asset('images/nursing-college.jpg'));
    }

    public function test_homepage_includes_a_link_to_the_nursing_page(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(route('nursing.index'))
            ->assertSee('nursing-nav-indicator')
            ->assertSee('Nursing')
            ->assertDontSee('nursing-home-feature');
    }

    public function test_admin_can_upload_replace_and_remove_nursing_section_images(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $hero = NursingPageSection::where('section_type', 'hero')->firstOrFail();
        $payload = [
            'section_type' => 'hero',
            'eyebrow' => $hero->eyebrow,
            'title' => $hero->title,
            'body' => $hero->body,
            'sort_order' => $hero->sort_order,
            'is_active' => 1,
        ];

        $this->put(route('admin.nursing.update', $hero), $payload + [
            'image' => UploadedFile::fake()->image('first-nurse.jpg'),
        ])->assertRedirect(route('admin.nursing.index'))->assertSessionHasNoErrors();

        $firstImage = $hero->fresh()->image_url;
        $this->assertStringStartsWith('nursing-page/', $firstImage);
        Storage::disk('public')->assertExists($firstImage);
        $this->get(route('admin.nursing.edit', $hero))->assertOk()
            ->assertSee(Storage::disk('public')->url($firstImage));
        $this->get(route('nursing.index'))->assertOk()->assertSee(asset('storage/'.$firstImage));

        $this->put(route('admin.nursing.update', $hero), $payload)
            ->assertRedirect(route('admin.nursing.index'))->assertSessionHasNoErrors();
        $this->assertSame($firstImage, $hero->fresh()->image_url);

        $this->put(route('admin.nursing.update', $hero), $payload + [
            'image' => UploadedFile::fake()->image('replacement-nurse.jpg'),
        ])->assertRedirect(route('admin.nursing.index'))->assertSessionHasNoErrors();

        $replacementImage = $hero->fresh()->image_url;
        $this->assertNotSame($firstImage, $replacementImage);
        Storage::disk('public')->assertMissing($firstImage);
        Storage::disk('public')->assertExists($replacementImage);

        $this->put(route('admin.nursing.update', $hero), $payload + ['remove_image' => 1])
            ->assertRedirect(route('admin.nursing.index'))->assertSessionHasNoErrors();
        $this->assertNull($hero->fresh()->image_url);
        Storage::disk('public')->assertMissing($replacementImage);
    }

    public function test_admin_can_create_update_and_delete_nursing_page_sections(): void
    {
        $this->actingAs(User::factory()->create());

        $section = NursingPageSection::where('section_type', 'feature')->firstOrFail();
        $this->get(route('admin.nursing.index'))->assertOk()->assertSee('Page Content');
        $this->get(route('admin.nursing.create'))->assertOk()->assertSee('New Page Content');
        $this->get(route('admin.nursing.edit', $section))->assertOk()->assertSee('Edit Page Content');
        $hero = NursingPageSection::where('section_type', 'hero')->firstOrFail();
        $college = NursingPageSection::where('section_type', 'content')->firstOrFail();
        $this->get(route('admin.nursing.edit', $hero))->assertOk()->assertSee(asset('images/nursing-care.jpg'));
        $this->get(route('admin.nursing.edit', $college))->assertOk()->assertSee(asset('images/nursing-college.jpg'));

        $this->put(route('admin.nursing.update', $section), [
            'section_type' => 'feature',
            'eyebrow' => 'Updated focus',
            'title' => 'Updated nursing focus',
            'body' => 'Updated information for prospective students.',
            'icon_label' => 'NC',
            'sort_order' => 3,
            'is_active' => 1,
        ])->assertRedirect(route('admin.nursing.index'))->assertSessionHasNoErrors();

        $this->assertSame('Updated nursing focus', $section->fresh()->title);

        $this->post(route('admin.nursing.store'), [
            'section_type' => 'content',
            'eyebrow' => 'Student life',
            'title' => 'A welcoming community',
            'body' => 'Students learn together.',
            'sort_order' => 7,
            'is_active' => 1,
        ])->assertRedirect(route('admin.nursing.index'))->assertSessionHasNoErrors();

        $created = NursingPageSection::where('title', 'A welcoming community')->firstOrFail();
        $this->delete(route('admin.nursing.destroy', $created))
            ->assertRedirect(route('admin.nursing.index'));
        $this->assertDatabaseMissing('nursing_page_sections', ['id' => $created->id]);
    }

    public function test_admin_rejects_a_second_hero(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('admin.nursing.store'), [
            'section_type' => 'hero',
            'eyebrow' => 'Duplicate hero',
            'title' => 'Another hero',
            'body' => 'This should be rejected.',
            'sort_order' => 7,
            'is_active' => 1,
        ])->assertRedirect()->assertSessionHasErrors('section_type');
    }

    public function test_nursing_content_is_protected(): void
    {
        $this->get(route('admin.nursing.index'))->assertRedirect(route('admin.login'));
    }
}
