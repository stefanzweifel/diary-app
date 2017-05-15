<?php

namespace Tests\Feature\Api;

use App\Entry;
use App\Journal;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class JournalEntryTest extends TestCase
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
    public function it_creates_a_new_entry_for_a_journal()
    {
        $user     = factory(User::class)->create();
        $token    = JWTAuth::fromUser($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);

        // Assert Call was successful
        $response = $this->call('POST', "api/journals/{$journal->id}/entries", [], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(201);


        // Assert Data was correctly stored
        // (Can't query database directly, because data is encrypted)
        $response = $this->call('GET', "api/journals/{$journal->id}/entries", [/* parameters */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_updates_entry_for_a_journal()
    {
        $this->markTestIncomplete('TODO: Rewrite Test');

        $user     = factory(User::class)->create();
        $token    = JWTAuth::fromUser($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);
        $entry = factory(Entry::class)->create([
            'journal_id' => $journal->id,
            'user_id' => $user->id
        ]);

        // Assert Call was successful
        $response = $this->call('PATCH', "api/journals/{$journal->id}/entries/{$entry->id}", [
            'title' => 'This is the Title',
            'content' => 'This is the Entry Content'
        ], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(204);


        // Assert Data was correctly stored
        // (Can't query database directly, because data is encrypted)
        $response = $this->call('GET', "api/journals/{$journal->id}/entries", [/* parameters */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertJsonFragment([
            'title' => 'This is the Title',
            'content' => 'This is the Entry Content'
        ]);

    }
}
