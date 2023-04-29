<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_sign_in(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $response = $this->postJson('/api/signin', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
        ]);
    }

    public function test_email_is_required(): void
    {
        $response = $this->postJson('/api/signin');
        $response->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email(): void
    {
        $response = $this->postJson('/api/signin', ['email' => 'test']);
        $response->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->postJson('/api/signin');
        $response->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_password_must_be_a_valid_a_string(): void
    {
        $response = $this->postJson('/api/signin', ['password' => 1234]);
        $response->assertInvalid(['password' => 'The password field must be a string.']);
    }

    public function test_the_user_cannot_sign_in_with_wrong_credentials(): void
    {
        $response = $this->postJson('/api/signin', [
            'email' => 'test@example.com',
            'password' => '1234',
        ]);
        $response->assertInvalid(['email' => 'These credentials do not match our records.']);
    }

    public function test_a_user_logged_in_cannot_send_a_post_request_to_do_sign_in(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/signin');
        $response->assertRedirectToRoute('home');
    }
}
