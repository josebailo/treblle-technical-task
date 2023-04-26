<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_sign_in(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->post('/signin', [
            'email' => 'test@example.com',
            'password' => '1234',
        ]);

        $response->assertRedirectToRoute('profile');
        $this->assertAuthenticatedAs($user);
    }

    public function test_email_is_required(): void
    {
        $response = $this->from('/signin')->post('/signin');

        $response->assertRedirectToRoute('signin')
            ->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email(): void
    {
        $response = $this->from('/signin')->post('/signin', ['email' => 'test']);

        $response->assertRedirectToRoute('signin')
            ->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->from('/signin')->post('/signin');

        $response->assertRedirectToRoute('signin')
            ->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_password_must_be_a_valid_a_string(): void
    {
        $response = $this->from('/signin')->post('/signin', ['password' => 1234]);

        $response->assertRedirectToRoute('signin')
            ->assertInvalid(['password' => 'The password field must be a string.']);
    }

    public function test_the_user_is_redirected_back_with_wrong_credentials(): void
    {
        $response = $this->from('/signin')->post('/signin', [
            'email' => 'test@example.com',
            'password' => '1234',
        ]);

        $response->assertRedirectToRoute('signin')
            ->assertInvalid(['email' => 'These credentials do not match our records.']);
    }

    public function test_a_user_logged_in_cannot_access_the_sign_in_page(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->get(route('signin'));

        $response->assertRedirectToRoute('home');
    }

    public function test_a_user_logged_in_cannot_send_a_post_request_to_do_sign_in(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->post('/signin');

        $response->assertRedirectToRoute('home');
    }

    public function test_a_logged_user_can_sign_out(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('signout'));

        $response->assertRedirectToRoute('signin');
        $this->assertGuest();
    }

    public function test_a_guest_cannot_sign_out(): void
    {
        $response = $this->post(route('signout'));

        $response->assertRedirectToRoute('signin');
    }
}
