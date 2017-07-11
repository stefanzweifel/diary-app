<?php

namespace Tests\Feature\Api;

use App\Entry;
use App\Media;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        Storage::fake('media');

        $entry = factory(Entry::class)->create();
        $user = $entry->user;
        Passport::actingAs($user);

        $entry->addMedia(UploadedFile::fake()->create('demo.text', 1000))->toMediaCollection();

        $response = $this->json('GET', "/api/entries/{$entry->id}/media");

        $response->assertJson([
            'data' => [
                [
                    'type' => 'media',
                    'attributes' => []
                ]
            ]
        ]);
        $response->assertStatus(200);
    }


    /** @test */
    public function it_stores_encrypted_file_for_an_entry()
    {
        Storage::fake('media');

        $entry = factory(Entry::class)->create();
        $user = $entry->user;
        Passport::actingAs($user);

        $response = $this->json('POST', "/api/entries/{$entry->id}/media", [
            'file' => UploadedFile::fake()->create('demo.text', 1000)
        ]);

        $response->assertJson([
            'data' => [
                'type' => 'media',
                'attributes' => []
            ]
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('media', [
            'model_id' => $entry->id
        ]);
    }

    /** @test */
    public function it_deletes_media_from_database()
    {
        Storage::fake('media');

        $entry = factory(Entry::class)->create();
        $media = $entry->addMedia(UploadedFile::fake()->create('demo.text', 1000))->toMediaCollection();
        Passport::actingAs($entry->user);

        $response = $this->json('DELETE', "/api/entries/{$entry->id}/media/{$media->id}");
        $response->assertStatus(204);

        $this->assertDatabaseMissing('media', [
            'id' => $media->id,
            'model_id' => $entry->id
        ]);
    }
}