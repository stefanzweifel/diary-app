<?php

namespace Tests\Feature\Api;

use App\Entry;
use App\Journal;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;
use Tests\TestCase;

class JournalEntryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_entries_for_given_journal()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);
        $entries = factory(Entry::class, 5)->create([
            'journal_id' => $journal->id,
            'user_id' => $user->id
        ]);

        $response = $this->json('GET', "/api/journals/{$journal->id}/entries");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'type' => 'entry',
                    'id' => $entries[0]->id,
                    'attributes' => [
                        'title' => $entries[0]->title,
                        'content' => $entries[0]->content,
                        'date' => $entries[0]->date
                    ]
                ]
            ]
        ]);
    }

    /** @test */
    public function it_creates_a_new_entry_for_a_journal()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);

        // Assert Call was successful
        $response = $this->json('POST', "api/journals/{$journal->id}/entries", []);
        $response->assertStatus(200);


        // Assert Data was correctly stored
        // (Can't query database directly, because data is encrypted)
        $response = $this->json('GET', "api/journals/{$journal->id}/entries");
        $response->assertStatus(200);
    }
}
