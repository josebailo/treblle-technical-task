<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_update_his_password(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/password', [
            'password' => 'password',
            'new_password' => 'qwerty',
            'new_password_confirmation' => 'qwerty',
        ]);

        $response->assertRedirectToRoute('password');
        $this->assertTrue(Hash::check('qwerty', $user->refresh()->password));
    }

    public function test_password_field_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('/password')->post('/password');

        $response->assertRedirectToRoute('password')
            ->assertInvalid(['password' => 'The password field is required.']);
    }

    public function test_new_password_field_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('/password')->post('/password');

        $response->assertRedirectToRoute('password')
            ->assertInvalid(['new_password' => 'The new password field is required.']);
    }

    public function test_new_password_field_must_be_confirmed(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('/password')->post('/password', [
            'new_password' => '1234',
        ]);

        $response->assertRedirectToRoute('password')
            ->assertInvalid(['new_password' => 'The new password field confirmation does not match.']);
    }
}
