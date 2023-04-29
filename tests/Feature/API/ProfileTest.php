<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
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
        Sanctum::actingAs($userBefore);
        $response = $this->postJson('/api/profile', [
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
        Sanctum::actingAs($userBefore);
        $response = $this->postJson('/api/profile', [
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
        Sanctum::actingAs($userA);
        $response = $this->postJson('/api/profile', [
            'name' => $userA->name,
            'email' => $userB->email,
        ]);

        $response->assertInvalid(['email' => 'The email has already been taken']);
    }

    public function test_name_is_required(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/profile');

        $response->assertInvalid(['name' => 'The name field is required.']);
    }

    public function test_email_is_required(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/profile');

        $response->assertInvalid(['email' => 'The email field is required.']);
    }

    public function test_email_must_be_a_valid_email_address(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/profile', [
            'email' => 'test',
        ]);

        $response->assertInvalid(['email' => 'The email field must be a valid email address.']);
    }

    public function test_only_logged_users_can_update_the_profile(): void
    {
        $response = $this->postJson('/api/profile');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }
}
