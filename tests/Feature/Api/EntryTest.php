<?php

namespace Tests\Feature\Api;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class EntryTest extends TestCase
{
    use DatabaseMigrations;

    public function getToken($user = null)
    {
        if (is_null($user)) {
            $user = factory(User::class)->create();
        }

        return JWTAuth::fromUser($user);
    }

    /** @test */
    public function it_returnsa_single_entry()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        $token = $this->getToken($user);

        $response = $this->call('GET', "api/entries/{$entries[0]->id}", [/* parameters */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertJsonFragment(['content' => $entries[0]->content]);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_a_404_error_if_user_tries_to_access_entry_which_does_not_belong_to_him()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        $token = $this->getToken($user);

        $entry = factory(Entry::class)->create();

        $response = $this->call('GET', "api/entries/{$entry->id}", [/* parameters */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_deletes_entry()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        $token = $this->getToken($user);

        $response = $this->call('DELETE', "api/entries/{$entries[0]->id}", [/* parameters */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(204);
    }

}
