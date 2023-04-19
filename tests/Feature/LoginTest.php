<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '1234',
        ]);

        $response->assertRedirectToRoute('profile');
        $this->assertAuthenticatedAs($user);
    }

    public function test_email_is_required(): void
    {
        $response = $this->from('/login')->post('/login');

        $response->assertRedirectToRoute('login')
            ->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email(): void
    {
        $response = $this->from('/login')->post('/login', ['email' => 'test']);

        $response->assertRedirectToRoute('login')
            ->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->from('/login')->post('/login');

        $response->assertRedirectToRoute('login')
            ->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_password_must_be_a_valid_a_string(): void
    {
        $response = $this->from('/login')->post('/login', ['password' => 1234]);

        $response->assertRedirectToRoute('login')
            ->assertInvalid(['password' => 'The password field must be a string.']);
    }

    public function test_the_user_is_redirected_back_with_wrong_credentials(): void
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
            'password' => '1234',
        ]);

        $response->assertRedirectToRoute('login')
            ->assertInvalid(['email' => 'These credentials do not match our records.']);
    }

    public function test_a_user_logged_in_cannot_access_the_login_page(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect();
    }
}
