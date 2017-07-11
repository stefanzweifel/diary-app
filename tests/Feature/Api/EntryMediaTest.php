<?php

namespace Tests\Feature\Api;

use App\Entry;
use App\Media;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class EntryMediaTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_returns_an_empty_array_if_entry_does_not_have_media()
    {
        $entry = factory(Entry::class)->create();
        $user = $entry->user;
        Passport::actingAs($user);

        $response = $this->json('GET', "/api/entries/{$entry->id}/media");

        $response->assertJson([
            'data' => [

            ]
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_attached_media_files_to_an_entry()
    {
        $entry = factory(Entry::class)->create();
        $user = $entry->user;
        Passport::actingAs($user);

        $base64 = base64_encode(UploadedFile::fake()->create('demo.text', 1000));

        $entry->media()->create([
            'blob' => $base64
        ]);

        $response = $this->json('GET', "/api/entries/{$entry->id}/media");

        $response->assertJson([
            'data' => [
                [
                    'type' => 'media',
                    'attributes' => [
                        'blob' => $base64
                    ]
                ]
            ]
        ]);
        $response->assertStatus(200);
    }


    /** @test */
    public function it_stores_encrypted_file_for_an_entry()
    {
        $entry = factory(Entry::class)->create();
        $user = $entry->user;
        Passport::actingAs($user);

        $base64 = base64_encode(UploadedFile::fake()->create('demo.text', 1000));

        $response = $this->json('POST', "/api/entries/{$entry->id}/media", [
            'file' => $base64
        ]);

        $response->assertJson([
            'data' => [
                'type' => 'media',
                'attributes' => [
                    'blob' => $base64
                ]
            ]
        ]);
        $response->assertStatus(200);


        $this->assertDatabaseHas('media', [
            'entry_id' => $entry->id
        ]);
    }

    /** @test */
    public function it_deletes_media_from_database()
    {
        $media = factory(Media::class)->create();
        $user = $media->entry->user;
        Passport::actingAs($user);

        $response = $this->json('DELETE', "/api/entries/{$media->entry->id}/media/{$media->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('media', [
            'id' => $media->id,
            'entry_id' => $media->entry->id
        ]);
    }
}