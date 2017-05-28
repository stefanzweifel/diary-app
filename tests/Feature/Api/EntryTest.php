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

        $response = $this->json('GET', "/api/entries/{$entries[0]->id}");

        $response->assertJson([
            'data' => [
                'attributes' => [
                    'title' => $entries[0]->title,
                    'content' => $entries[0]->content,
                    'date' => $entries[0]->date
                ],
                'id' => $entries[0]->id,
                'type' => 'entry'
            ]
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_a_403_error_if_user_tries_to_access_entry_which_does_not_belong_to_him()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        Passport::actingAs($user);

        $entry = factory(Entry::class)->create();

        $response = $this->json('GET', "/api/entries/{$entry->id}");
        $response->assertStatus(403);
    }

    /** @test */
    public function it_deletes_entry()
    {
        $entries = factory(Entry::class, 5)->create();
        $user = $entries[0]->user;
        Passport::actingAs($user);

        $response = $this->json('delete', "/api/entries/{$entries[0]->id}");
        $response->assertStatus(204);
    }

    /** @test */
    public function it_does_not_delete_entry_of_different_user()
    {
        $entry = factory(Entry::class)->create();
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $response = $this->json('delete', "/api/entries/{$entry->id}");
        $response->assertStatus(403);
    }


    /** @test */
    public function it_updates_a_single_entry()
    {
        $entry = factory(Entry::class)->create();
        Passport::actingAs($entry->user);

        $response = $this->json('PATCH', "/api/entries/{$entry->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);

        $response->assertStatus(200);
        $response->assertExactJson([]);


        $showResponse = $this->json('GET', "/api/entries/{$entry->id}");
        $showResponse->assertJsonFragment([
            'title' => 'Updated Title',
            'content' => 'Updated Content'
        ]);
    }

    /** @test */
    public function it_throws_validation_error_when_updating_an_entry()
    {
        $entry = factory(Entry::class)->create();
        Passport::actingAs($entry->user);

        $response = $this->json('PATCH', "/api/entries/{$entry->id}", [
            'title' => '',
            'content' => ''
        ]);

        $response->assertStatus(422);

        $response->assertJson([
            'title' => [
                'The title field is required.'
            ],
            'content' => [
                'The content field is required.'
            ]
        ]);

    }

}
