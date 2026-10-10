<?php

namespace Tests\Feature;

use App\Models\LeadershipMessage;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            'message' => 'Original message',
            'tags' => [],
        ]));

        $this->put(route('admin.leadership.update', $message), $this->payload() + [
            'tags' => 'Teaching, Care',
            'image' => null,
        ])->assertRedirect(route('admin.leadership.index'))->assertSessionHasNoErrors();

        $message->refresh();
        $this->assertSame('A commitment to learning', $message->title);
        $this->assertSame($this->payload()['message'], $message->message);
        $this->assertSame(['Teaching', 'Care'], $message->tags);
        $this->assertTrue($message->is_active);
    }

    public function test_admin_can_update_message_and_upload_a_larger_profile_picture(): void
    {
        Storage::fake('public');
        $message = LeadershipMessage::create(array_replace($this->payload(), [
            'message' => 'Original message',
            'image_path' => 'leadership/original.jpg',
        ]));
        $longMessage = str_repeat('A thoughtful message for our students and community.', 25);

        $this->put(route('admin.leadership.update', $message), array_replace($this->payload(), [
            'message' => $longMessage,
            'image_path' => 'leadership/original.jpg',
            'image' => UploadedFile::fake()->image('leadership.jpg')->size(3072),
        ]))->assertRedirect(route('admin.leadership.index'))->assertSessionHasNoErrors();

        $message->refresh();
        $this->assertSame($longMessage, $message->message);
        $this->assertNotSame('leadership/original.jpg', $message->image_path);
        Storage::disk('public')->assertExists($message->image_path);
    }

    public function test_admin_can_create_a_leadership_message(): void
    {
        $this->post(route('admin.leadership.store'), $this->payload() + ['tags' => 'Teaching'])
            ->assertRedirect(route('admin.leadership.index'))->assertSessionHasNoErrors();

        $this->assertDatabaseHas('leadership_messages', ['role' => 'Director', 'title' => 'A commitment to learning']);
    }

    public function test_public_can_read_complete_active_leadership_message(): void
    {
        $message = LeadershipMessage::create(array_replace($this->payload(), [
            'message' => str_repeat('A complete leadership message for the college community. ', 25),
            'tags' => ['Learning'],
            'is_active' => true,
        ]));

        $this->get(route('leadership.show', $message))
            ->assertOk()
            ->assertSee($message->title)
            ->assertSee('A complete leadership message for the college community.')
            ->assertSee($message->imageUrl())
            ->assertSee('Leadership Messages');
    }

    public function test_public_cannot_read_inactive_leadership_message(): void
    {
        $message = LeadershipMessage::create(array_replace($this->payload(), [
            'is_active' => false,
        ]));

        $this->get(route('leadership.show', $message))->assertNotFound();
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
