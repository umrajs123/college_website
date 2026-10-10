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
}
