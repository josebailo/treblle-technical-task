<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);
        $user = User::where('email', 'test@example.com')->first();

        $response->assertRedirectToRoute('home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_a_user_logged_in_cannot_access_the_register_page(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->get(route('register'));

        $response->assertRedirectToRoute('home');
    }

    public function test_a_user_logged_in_cannot_send_a_post_request_to_do_register(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->post('/register');

        $response->assertRedirectToRoute('home');
    }

    public function test_name_is_required(): void
    {
        $response = $this->from('/register')->post('/register');

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['name' => 'The name field is required.']);
    }

    public function test_email_is_required(): void
    {
        $response = $this->from('/register')->post('/register');

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email(): void
    {
        $response = $this->from('/register')->post('/register', ['email' => 'test']);

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->from('/register')->post('/register');

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_password_confirmation_is_required(): void
    {
        $response = $this->from('/register')->post('/register');

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['password_confirmation' => 'The password confirmation field is required.']);
    }

    public function test_password_confirmation_must_be_equal_than_the_password(): void
    {
        $response = $this->from('/register')->post('/register', [
            'password' => '1234',
            'password_confirmation' => '1111',
        ]);

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['password' => 'The password field confirmation does not match.']);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        $response->assertRedirectToRoute('register')
            ->assertInvalid(['email' => 'The email has already been taken.']);
    }
}
