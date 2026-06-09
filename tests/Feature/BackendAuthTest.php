<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BackendAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_can_be_rendered(): void
    {
        $response = $this->get(route('backend.login'));
        $response->assertStatus(200);
    }

    public function test_backend_beranda_redirects_to_login_when_unauthenticated(): void
    {
        $response = $this->get(route('backend.beranda'));
        $response->assertRedirect(route('backend.login'));
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'status' => 1,
            'role' => '1',
        ]);

        $response = $this->post(route('backend.login'), [
            'email' => 'admin@test.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('backend.beranda'));
        $this->assertAuthenticated();
    }

    public function test_admin_cannot_login_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'status' => 1,
        ]);

        $response = $this->post(route('backend.login'), [
            'email' => 'admin@test.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHas('error', 'Login Gagal');
        $this->assertGuest();
    }

    public function test_inactive_admin_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'inactive@test.com',
            'password' => bcrypt('password'),
            'status' => 0,
        ]);

        $response = $this->post(route('backend.login'), [
            'email' => 'inactive@test.com',
            'password' => 'password',
        ]);

        $response->assertSessionHas('error', 'User belum aktif');
        $this->assertGuest();
    }

    public function test_admin_can_logout(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'status' => 1,
        ]);

        $this->actingAs($user);
        $response = $this->post(route('backend.logout'));
        $response->assertRedirect(route('backend.login'));
        $this->assertGuest();
    }
}
