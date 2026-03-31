<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('inspector.dashboard'));
    }

    public function test_admin_users_can_authenticate_using_the_generic_login_screen(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.dashboard.index'));
    }

    public function test_admin_generic_login_ignores_inspector_intended_redirects(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->withSession([
            'url.intended' => route('inspector.dashboard'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.dashboard.index'));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_admin_users_can_authenticate_through_the_admin_portal(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.dashboard.index'));
    }

    public function test_inspectors_cannot_authenticate_through_the_admin_portal(): void
    {
        $user = User::factory()->create([
            'role' => 'inspector',
        ]);

        $response = $this->from(route('admin.login'))->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
    }

    public function test_inspectors_are_forbidden_from_accessing_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'inspector',
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard.index'));

        $response->assertForbidden();
    }
}
