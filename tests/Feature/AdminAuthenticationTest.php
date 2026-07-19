<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_admin_dashboard_to_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@scps.test',
            'password' => 'StrongPass2026',
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@scps.test',
            'password' => 'StrongPass2026',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }

    public function test_login_lockout_returns_to_form_with_countdown(): void
    {
        User::factory()->create([
            'email' => 'admin@scps.test',
            'password' => 'StrongPass2026',
        ]);

        foreach (range(1, 5) as $attempt) {
            $this->post('/admin/login', [
                'email' => 'admin@scps.test',
                'password' => 'wrong-password',
            ]);
        }

        $this->post('/admin/login', [
            'email' => 'admin@scps.test',
            'password' => 'wrong-password',
        ])
            ->assertRedirect()
            ->assertSessionHas('lockout_seconds')
            ->assertSessionHasErrors('email');
    }

    public function test_login_page_shows_cooldown_state(): void
    {
        $this->withSession(['lockout_seconds' => 60])
            ->get('/admin/login')
            ->assertOk()
            ->assertSee('Cooling down')
            ->assertSee('data-login-countdown', false)
            ->assertSee('disabled', false);
    }

    public function test_authenticated_admin_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => 'OldStrongPass2026',
        ]);

        $this->actingAs($user)
            ->put(route('admin.security.update'), [
                'current_password' => 'OldStrongPass2026',
                'password' => 'NewStrongPass2026',
                'password_confirmation' => 'NewStrongPass2026',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertTrue(Hash::check('NewStrongPass2026', $user->fresh()->password));
    }
}
