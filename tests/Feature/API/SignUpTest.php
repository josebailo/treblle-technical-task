<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_sign_up(): void
    {
        $response = $this->postJson('/api/signup', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);
        $user = User::where('email', 'test@example.com')->first();

        $response->assertStatus(Response::HTTP_OK);
        $this->assertAuthenticatedAs($user);
    }

    public function test_a_user_logged_in_cannot_send_a_post_request_to_do_sign_up(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        Sanctum::actingAs($user);
        $response = $this->postJson('/api/signup');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_name_is_required(): void
    {
        $response = $this->from('/signup')->postJson('/api/signup');

        $response->assertInvalid(['name' => 'The name field is required.']);
    }

    public function test_email_is_required(): void
    {
        $response = $this->from('/signup')->postJson('/api/signup');

        $response->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email(): void
    {
        $response = $this->from('/signup')->postJson('/api/signup', ['email' => 'test']);

        $response->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->from('/signup')->postJson('/api/signup');

        $response->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_password_confirmation_is_required(): void
    {
        $response = $this->from('/signup')->postJson('/api/signup');

        $response->assertInvalid(['password_confirmation' => 'The password confirmation field is required.']);
    }

    public function test_password_confirmation_must_be_equal_than_the_password(): void
    {
        $response = $this->from('/signup')->postJson('/api/signup', [
            'password' => '1234',
            'password_confirmation' => '1111',
        ]);

        $response->assertInvalid(['password' => 'The password field confirmation does not match.']);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->from('/signup')->postJson('/api/signup', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        $response->assertInvalid(['email' => 'The email has already been taken.']);
    }
}
