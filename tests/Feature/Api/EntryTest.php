<?php

namespace Tests\Feature\Api;

use App\Entry;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returnsa_single_entry()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        Passport::actingAs($user);

        $response = $this->get("/api/entries/{$entries[0]->id}");

        $response->assertJsonFragment(['content' => $entries[0]->content]);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_a_404_error_if_user_tries_to_access_entry_which_does_not_belong_to_him()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        Passport::actingAs($user);

        $entry = factory(Entry::class)->create();

        $response = $this->get("/api/entries/{$entry->id}");
        $response->assertStatus(404);
    }

    /** @test */
    public function it_deletes_entry()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        Passport::actingAs($user);

        $response = $this->delete("/api/entries/{$entries[0]->id}");
        $response->assertStatus(204);
    }

}
