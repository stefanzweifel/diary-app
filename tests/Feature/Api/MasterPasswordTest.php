<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Laravel\Passport\Passport;
use Tests\TestCase;

class MasterPasswordTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_error_if_no_data_has_been_passed()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('POST', '/api/master-password', []);

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
                'The password field is required.'
            ],
            'password_confirmation' => [
                'The password confirmation field is required.'
            ]
        ]);
    }

    /** @test */
    public function it_returns_error_if_password_confirmation_does_not_match()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('POST', '/api/master-password', [
            'password' => 'secret-password',
            'password_confirmation' => 'password-secret'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
                'The password confirmation does not match.'
            ]
        ]);
    }

    /** @test */
    public function it_returns_succesful_response_after_master_password_has_been_saved()
    {
        $user     = factory(User::class)->create();
        Passport::actingAs($user);
        $response = $this->json('POST', '/api/master-password', [
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password'
        ]);

        $response->assertStatus(201);
        $response->assertJson([]);
    }


    /** @test */
    public function it_returns_error_if_unlock_request_fails()
    {
        $user     = factory(User::class)->states('with_master_password')->create();
        Passport::actingAs($user);
        $response = $this->json('POST', '/api/master-password/unlock', [
            'password' => 'wrong-master-password'
        ]);

        $response->assertStatus(422);
        $response->assertJson([
            'password' => [
                'Masterpassword does not match.'
            ]
        ]);
    }

    /** @test */
    public function it_returns_encryption_key_if_unlock_succeeds()
    {
        $user     = factory(User::class)->states('with_master_password')->create();
        Passport::actingAs($user);
        $response = $this->json('POST', '/api/master-password/unlock', [
            'password' => 'master-password'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'encryption_key' => $user->encryption_key
        ]);
    }

}
