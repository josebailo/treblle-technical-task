<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_update_his_profile_data(): void
    {
        $userBefore = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);
        $response = $this->actingAs($userBefore)->post('/profile', [
            'name' => 'Jane Doe',
            'email' => 'new-test@example.com',
        ]);
        $userAfter = User::first();

        $response->assertRedirectToRoute('profile');
        $this->assertEquals('Jane Doe', $userAfter->name);
        $this->assertEquals('new-test@example.com', $userAfter->email);
        $this->assertEquals($userBefore->password, $userAfter->password);
    }

    public function test_a_user_can_save_his_profile_data_keeping_the_same_data(): void
    {
        $userBefore = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
        ]);
        $response = $this->actingAs($userBefore)->post('/profile', [
            'name' => $userBefore->name,
            'email' => $userBefore->email,
        ]);
        $userAfter = User::first();

        $response->assertRedirectToRoute('profile');
        $this->assertEquals($userBefore->name, $userAfter->name);
        $this->assertEquals($userBefore->email, $userAfter->email);
        $this->assertEquals($userBefore->password, $userAfter->password);
    }

    public function test_a_user_cannot_update_his_email_if_is_in_use_by_other_user(): void
    {
        [$userA, $userB] = User::factory()->count(2)->create();
        $response = $this->actingAs($userA)->from('profile')->post('/profile', [
            'name' => $userA->name,
            'email' => $userB->email,
        ]);

        $response->assertRedirectToRoute('profile')
            ->assertInvalid(['email' => 'The email has already been taken']);
    }

    public function test_name_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('/profile')->post('/profile');

        $response->assertRedirectToRoute('profile')
            ->assertInvalid(['name' => 'The name field is required.']);
    }

    public function test_email_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('/profile')->post('/profile');

        $response->assertRedirectToRoute('profile')
            ->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email_address(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('/profile')->post('/profile', [
            'email' => 'test',
        ]);

        $response->assertRedirectToRoute('profile')
            ->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_only_logged_users_can_access_the_profile_page(): void
    {
        $response = $this->get(route('profile'));

        $response->assertRedirectToRoute('login');
    }

    public function test_only_logged_users_can_update_the_profile(): void
    {
        $response = $this->post('/profile');

        $response->assertRedirectToRoute('login');
    }
}
