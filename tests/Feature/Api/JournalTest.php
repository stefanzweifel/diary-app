<?php

namespace Tests\Feature\Api;

use App\Journal;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;
use Tests\TestCase;

class JournalTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_an_empty_array_of_journals_for_a_valid_user()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('GET', '/api/journals');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => []
        ]);
    }

    /** @test */
    public function it_returns_journals_for_user()
    {
        $user     = factory(User::class)->create();
        $journals = factory(Journal::class, 5)->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->json('get', '/api/journals');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $journals[0]->id,
            'title' => $journals[0]->title
        ]);
        $response->assertJsonFragment([
            'pagination' => [
                'count' => 5,
                'current_page' => 1,
                'per_page' => 25,
                'total' => 5,
                'total_pages' => 1
            ]
        ]);
    }

    /** @test */
    public function it_creates_a_new_journal_for_passed_user()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);

        $response = $this->json('post', '/api/journals', ['title' => 'This is a Demo']);
        $response->assertStatus(201);

        // Assert Data was correctly stored
        // (Can't query database directly, because data is encrypted)

        $response = $this->json('GET', '/api/journals');
        $response->assertJsonFragment(['title' => 'This is a Demo']);
    }

    /** @test */
    public function it_returns_journal_resource_for_passed_journal_id()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $journal = factory(Journal::class)->create(['user_id' => $user->id]);

        // Assert Call was successful
        $response = $this->json('GET', "/api/journals/{$journal->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $journal->title]);

        $response->assertJson([
            'data' => [
                'type' => 'journal',
                'id' => $journal->id,
                'attributes' => [
                    'title' => $journal->title
                ]
            ]
        ]);
    }

    /** @test */
    public function it_returns_a_403_error_if_user_tries_to_access_journal_which_does_not_belong_to_him()
    {
        $user = factory(User::class)->create();
        $journal = factory(Journal::class)->create();
        Passport::actingAs($user);

        $response = $this->json('GET', "/api/journals/{$journal->id}");
        $response->assertStatus(403);
    }

    /** @test */
    public function it_updates_journal_title()
    {
        $journal = factory(Journal::class)->create();
        Passport::actingAs($journal->user);

        $response = $this->json('PATCH', "/api/journals/{$journal->id}", [
            'title' => 'Demo'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_error_if_user_wants_to_update_journal_which_does_not_belong_to_him()
    {
        $journal = factory(Journal::class)->create();
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $response = $this->json('PATCH', "/api/journals/{$journal->id}", [
            'title' => 'Demo'
        ]);

        $response->assertStatus(403);
    }


    /** @test */
    public function it_deletes_journal()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);

        $response = $this->json('DELETE', "/api/journals/{$journal->id}");
        $response->assertStatus(204);
    }

    /** @test */
    public function it_throws_error_if_user_tries_to_delete_journal_which_does_not_belong_to_him()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);
        $journal = factory(Journal::class)->create();

        $response = $this->json('DELETE', "/api/journals/{$journal->id}");
        $response->assertStatus(403);
    }

    /** @test */
    public function it_throws_error_if_user_tries_to_delete_journal_which_does_not_exist()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $response = $this->json('DELETE', "/api/journals/foo-bar");
        $response->assertStatus(404);
    }

}
