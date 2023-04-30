<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_sign_up(): void
    {
        $response = $this->post('/signup', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);
        $user = User::where('email', 'test@example.com')->first();

        $response->assertRedirectToRoute('home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_a_user_logged_in_cannot_access_the_sign_up_page(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->get(route('signup'));

        $response->assertRedirectToRoute('home');
    }

    public function test_a_user_logged_in_cannot_send_a_post_request_to_do_sign_up(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('1234'),
        ]);
        $response = $this->actingAs($user)->post('/signup');

        $response->assertRedirectToRoute('home');
    }

    public function test_name_is_required(): void
    {
        $response = $this->from('/signup')->post('/signup');

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['name' => 'The name field is required.']);
    }

    public function test_email_is_required(): void
    {
        $response = $this->from('/signup')->post('/signup');

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email(): void
    {
        $response = $this->from('/signup')->post('/signup', ['email' => 'test']);

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_password_is_required(): void
    {
        $response = $this->from('/signup')->post('/signup');

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_password_confirmation_is_required(): void
    {
        $response = $this->from('/signup')->post('/signup');

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['password_confirmation' => 'The password confirmation field is required.']);
    }

    public function test_password_confirmation_must_be_equal_than_the_password(): void
    {
        $response = $this->from('/signup')->post('/signup', [
            'password' => '1234',
            'password_confirmation' => '1111',
        ]);

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['password' => 'The password field confirmation does not match.']);
    }

    public function test_email_must_be_unique(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $response = $this->from('/signup')->post('/signup', [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ]);

        $response->assertRedirectToRoute('signup')
            ->assertInvalid(['email' => 'The email has already been taken.']);
    }

    public function test_sign_up_page_renders_inertia_sign_up_page_component()
    {
        $this->get(route('signup'))
            ->assertInertia(fn (AssertableInertia $page) => $page->component('SignUp'));
    }
}
