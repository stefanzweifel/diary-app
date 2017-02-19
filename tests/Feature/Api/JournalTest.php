<?php

namespace Tests\Feature\Api;

use App\Journal;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class JournalTest extends TestCase
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
    public function it_returns_401_if_no_token_was_passed()
    {
        $response = $this->get('api/journals');
        $response->assertStatus(401);
    }

    /** @test */
    public function it_returns_401_if_invalid_token_was_passed()
    {
        $token = 'this_is_an_invalid_token';

        $response = $this->call('GET', 'api/journals', [/* params */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(401);
    }

    /** @test */
    public function it_returns_an_empty_array_of_journals_for_a_valid_user()
    {
        $token = $this->getToken();

        $response = $this->call('GET', 'api/journals', [/* params */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);

        $response->assertStatus(200);
        $response->assertJsonStructure([]);
    }

    /** @test */
    public function it_returns_journals_for_user()
    {
        $user     = factory(User::class)->create();
        $token    = JWTAuth::fromUser($user);
        $journals = factory(Journal::class, 5)->create(['user_id' => $user->id]);

        $response = $this->call('GET', 'api/journals', [/* params */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);

        $response->assertStatus(200);
        $response->assertJson([
            'journals' => $journals->toArray()
        ]);
    }

    /** @test */
    public function it_creates_a_new_journal_for_passed_user()
    {
        $user     = factory(User::class)->create();
        $token    = JWTAuth::fromUser($user);

        // Assert Call was successful
        $response = $this->call('POST', 'api/journals', [
            'title' => 'This is a Demo'
        ], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(201);

        // Assert Data was correctly stored
        // (Can't query database directly, because data is encrypted)
        $response = $this->call('GET', 'api/journals', [/* parameters */], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertJsonFragment(['title' => 'This is a Demo']);

        $data = $response->json();
        $this->assertEquals($data['journals'][0]['title'], 'This is a Demo');
    }

    /** @test */
    public function it_returns_journal_resource_for_passed_journal_id()
    {
        $user = factory(User::class)->create();
        $token = $this->getToken($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);

        // Assert Call was successful
        $response = $this->call('GET', "api/journals/{$journal->id}", [], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => $journal->title]);
    }

    /** @test */
    public function it_returns_a_404_error_if_user_tries_to_access_journal_which_does_not_belong_to_him()
    {
        $user = factory(User::class)->create();
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);
        $token = $this->getToken();


        // Assert Call was successful
        $response = $this->call('GET', "api/journals/{$journal->id}", [], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(404);
    }

    /** @test */
    public function it_updates_journal_title()
    {
        // it updates journal title
    }

    /** @test */
    public function it_deletes_journal()
    {
        $user = factory(User::class)->create();
        $token = $this->getToken($user);
        $journal = factory(Journal::class)->create(['user_id' => $user->id]);

        // Assert Call was successful
        $response = $this->call('DELETE', "api/journals/{$journal->id}", [], [/* cookies */], [/* files */], ['HTTP_Authorization' => 'Bearer '.$token]);
        $response->assertStatus(204);
    }

}
