<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_update_his_password(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson('/api/password', [
            'password' => 'password',
            'new_password' => 'qwerty',
            'new_password_confirmation' => 'qwerty',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertTrue(Hash::check('qwerty', $user->refresh()->password));
    }

    public function test_password_field_is_required(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/password');

        $response->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_new_password_field_is_required(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/password');

        $response->assertInvalid(['new_password' => 'The new password field is required.']);
    }

    public function test_new_password_field_must_be_confirmed(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->postJson('/api/password', [
            'new_password' => '1234',
        ]);

        $response->assertInvalid(['new_password' => 'The new password field confirmation does not match.']);
    }
}
