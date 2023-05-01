<?php

namespace Tests\Feature\Web;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class TokensTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_cannot_access_the_tokens_list_page(): void
    {
        $response = $this->get(route('tokens'));

        $response->assertRedirectToRoute('signin');
    }

    public function test_a_user_can_access_the_tokens_list_page(): void
    {
        $user = User::factory()->create();
        $user->createToken('test');
        $this->actingAs($user)
            ->get(route('tokens'))
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Tokens')
                ->has('tokens', 1)
            );
    }

    public function test_a_user_can_delete_a_token()
    {
        $user = User::factory()->create();
        $newToken = $user->createToken('test');
        $response = $this->actingAs($user)
            ->from('tokens')
            ->delete(route('tokens.destroy', ['token' => $newToken->accessToken->id]));

        $response->assertRedirectToRoute('tokens');
        $this->assertEmpty($user->tokens()->get());
    }

    public function test_a_user_cannot_delete_a_token_that_does_not_exist()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->from('tokens')
            ->delete(route('tokens.destroy', ['token' => 1]));

        $response->assertNotFound();
    }

    public function test_a_user_cannot_delete_a_token_of_another_user()
    {
        [$userA, $userB] = User::factory()->count(2)->create();
        $newToken = $userA->createToken('test');
        $response = $this->actingAs($userB)
            ->from('tokens')
            ->delete(route('tokens.destroy', ['token' => $newToken->accessToken->id]));

        $response->assertRedirectToRoute('tokens');
    }

    public function test_a_guest_cannot_create_new_tokens(): void
    {
        $response = $this->post(route('tokens.store'));

        $response->assertRedirectToRoute('signin');
    }

    public function test_a_user_can_create_new_tokens(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('tokens')->post(route('tokens.store'), [
            'name' => 'test',
        ]);
        $tokens = $user->tokens()->get();

        $this->assertEquals($tokens->count(), 1);
        $this->assertEquals($tokens->first()->name, 'test');
        $response->assertRedirectToRoute('tokens');
    }

    public function test_name_is_required(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->from('tokens')->post(route('tokens.store'));

        $response->assertRedirectToRoute('tokens')
            ->assertInvalid(['name' => 'The name field is required.']);;
    }

    public function test_a_guest_cannot_access_the_create_token_page(): void
    {
        $response = $this->get(route('tokens.create'));

        $response->assertRedirectToRoute('signin');
    }

    public function test_a_user_can_access_the_create_token_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('tokens.create'))
            ->assertInertia(fn (AssertableInertia $page) => $page->component('NewToken'));
    }
}
