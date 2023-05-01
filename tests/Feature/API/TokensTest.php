<?php

namespace Tests\Feature\API;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TokensTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_access_the_tokens_list(): void
    {
        $user = User::factory()->create();
        $user->createToken('test');
        Sanctum::actingAs($user);
        $response = $this->get('/api/tokens');
        $response->assertSuccessful()
            ->assertJsonFragment([
                'name' => 'test',
            ]);
    }

    public function test_a_user_can_delete_a_token()
    {
        $user = User::factory()->create();
        $newToken = $user->createToken('test');
        Sanctum::actingAs($user);
        $response = $this->delete("/api/tokens/{$newToken->accessToken->id}");

        $response->assertSuccessful();
        $this->assertEmpty($user->tokens()->get());
    }

    public function test_a_user_cannot_delete_a_token_that_does_not_exist()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->delete('/api/tokens/1');

        $response->assertNotFound();
    }

    public function test_a_user_cannot_delete_a_token_of_another_user()
    {
        [$userA, $userB] = User::factory()->count(2)->create();
        $newToken = $userA->createToken('test');
        Sanctum::actingAs($userB);
        $response = $this->delete("/api/tokens/{$newToken->accessToken->id}");

        $response->assertUnauthorized();
    }

    public function test_a_user_can_create_new_tokens(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->post('/api/tokens', [
            'name' => 'test',
        ]);
        $tokens = $user->tokens()->get();

        $this->assertEquals($tokens->count(), 1);
        $this->assertEquals($tokens->first()->name, 'test');
        $response->assertSuccessful();
    }

    public function test_name_is_required(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/tokens');

        $response->assertInvalid(['name' => 'The name field is required.']);;
    }
}
