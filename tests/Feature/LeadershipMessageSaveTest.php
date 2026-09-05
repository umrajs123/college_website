<?php

namespace Tests\Feature;

use App\Models\LeadershipMessage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LeadershipMessageSaveTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Explicitly isolate these tests from the website database, including cached config.
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

    public function test_admin_can_save_a_leadership_message(): void
    {
        $message = LeadershipMessage::create(array_replace($this->payload(), [
            'title' => 'Original title',
            'tags' => [],
        ]));

        $this->put(route('admin.leadership.update', $message), $this->payload() + [
            'tags' => 'Teaching, Care',
            'image' => null,
        ])->assertRedirect(route('admin.leadership.index'))->assertSessionHasNoErrors();

        $message->refresh();
        $this->assertSame('A commitment to learning', $message->title);
        $this->assertSame(['Teaching', 'Care'], $message->tags);
        $this->assertTrue($message->is_active);
    }

    public function test_admin_can_create_a_leadership_message(): void
    {
        $this->post(route('admin.leadership.store'), $this->payload() + ['tags' => 'Teaching'])
            ->assertRedirect(route('admin.leadership.index'))->assertSessionHasNoErrors();

        $this->assertDatabaseHas('leadership_messages', ['role' => 'Director', 'title' => 'A commitment to learning']);
    }

    public function test_user_credentials_are_hidden_when_serialized(): void
    {
        $user = User::factory()->make(['remember_token' => 'private-token']);

        $this->assertArrayNotHasKey('password', $user->toArray());
        $this->assertArrayNotHasKey('remember_token', $user->toArray());
    }

    private function payload(): array
    {
        return [
            'role' => 'Director',
            'title' => 'A commitment to learning',
            'subtitle' => 'Welcome to our college',
            'message' => 'Supporting students through curiosity, care, and practical learning.',
            'accent' => 'director',
            'sort_order' => 1,
            'is_active' => 1,
        ];
    }
}
