<?php

namespace Tests\Feature;

use App\Models\AboutSection;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AboutSectionSaveTest extends TestCase
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
        $this->actingAs(User::factory()->create());
    }

    public function test_admin_can_save_about_body_longer_than_1200_characters(): void
    {
        $section = AboutSection::create([
            'eyebrow' => 'About SCPS',
            'heading' => 'A College Built for Serious Pharmacy Education',
            'body' => 'Original body.',
            'accent' => 'sky',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        $longBody = str_repeat('Our college supports students through learning, research, and service.', 25);

        $this->put(route('admin.about.update', $section), [
            'eyebrow' => 'About SCPS',
            'heading' => 'A College Built for Serious Pharmacy Education',
            'body' => $longBody,
            'accent' => 'sky',
            'sort_order' => 1,
            'is_active' => 1,
        ])->assertRedirect(route('admin.about.index'))->assertSessionHasNoErrors();

        $this->assertSame($longBody, $section->fresh()->body);
    }

    public function test_about_blocks_are_not_created_through_the_admin_anymore(): void
    {
        $this->get('/admin/about/create')->assertNotFound();
        $this->post('/admin/about', [])->assertMethodNotAllowed();
    }

    public function test_about_admin_shows_preview_and_edit_actions_without_add_block_action(): void
    {
        $section = AboutSection::create([
            'eyebrow' => 'About SCPS',
            'heading' => 'A College Built for Serious Pharmacy Education',
            'accent' => 'sky',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('admin.about.index'))
            ->assertOk()
            ->assertSee('about-admin-actions')
            ->assertSee(route('about.show'))
            ->assertSee(route('admin.about.edit', $section))
            ->assertSee('Preview About Us')
            ->assertSee('Edit About Us')
            ->assertDontSee('Add About Block');
    }

    public function test_public_about_page_shows_the_complete_active_story_and_image(): void
    {
        $body = "First complete paragraph.\n\nSecond complete paragraph with the rest of the college story.";
        $section = AboutSection::create([
            'eyebrow' => 'About SCPS',
            'heading' => 'A College Built for Serious Pharmacy Education',
            'body' => $body,
            'image_path' => 'https://example.test/about.jpg',
            'image_alt' => 'Students learning in a lab',
            'features' => [['text' => 'Purpose-built teaching laboratories', 'accent' => 'sky']],
            'accent' => 'sky',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $this->get(route('about.show'))
            ->assertOk()
            ->assertSee($section->heading)
            ->assertSee('First complete paragraph.')
            ->assertSee('Second complete paragraph with the rest of the college story.')
            ->assertSee('https://example.test/about.jpg')
            ->assertSee('Students learning in a lab')
            ->assertSee('Purpose-built teaching laboratories');
    }

    public function test_public_about_page_is_unavailable_when_there_is_no_active_story(): void
    {
        AboutSection::create([
            'eyebrow' => 'About SCPS',
            'heading' => 'Hidden About Story',
            'accent' => 'sky',
            'sort_order' => 1,
            'is_active' => false,
        ]);

        $this->get(route('about.show'))->assertNotFound();
    }
}
