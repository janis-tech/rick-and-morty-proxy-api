<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\Helpers\MocksRickAndMortyApi;
use Tests\TestCase;

class CharacterControllerTest extends TestCase
{
    use MocksRickAndMortyApi;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_list_characters(): void
    {
        $this->mockCharactersList();

        $response = $this->getJson('/api/v1/characters');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'status',
                    'species',
                    'type',
                    'gender',
                    'origin',
                    'location',
                    'image',
                    'episode',
                    'url',
                    'created',
                ],
            ],
            'message',
            'pagination',
        ]);

        $response->assertJson([
            'status' => 'success',
            'data' => [
                [
                    'id' => 1,
                    'name' => 'Rick Sanchez',
                ],
            ],
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_get_a_character_by_id(): void
    {
        $character_id = 1;

        $this->mockCharacterById($character_id);

        $response = $this->getJson("/api/v1/characters/{$character_id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'name',
                'status',
                'species',
                'type',
                'gender',
                'origin',
                'location',
                'image',
                'episode',
                'url',
                'created',
            ],
        ]);

        $response->assertJson([
            'status' => 'success',
            'data' => [
                'id' => $character_id,
                'name' => 'Rick Sanchez',
                'status' => 'Alive',
            ],
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_404_when_character_not_found(): void
    {
        $character_id = 9999;

        $this->mockCharacterById($character_id, false);

        $response = $this->getJson("/api/v1/characters/{$character_id}");

        $response->assertStatus(404);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Character not found',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_api_errors_gracefully(): void
    {
        // Mock a server error
        $this->mockServerError();

        $response = $this->getJson('/api/v1/characters');

        $response->assertStatus(500);
        $response->assertJson([
            'status' => 'error',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_filter_characters_by_name_and_status(): void
    {
        $this->mockCharactersList();

        $response = $this->getJson('/api/v1/characters?name=Rick&status=alive');

        $response->assertStatus(200);
        $response->assertJsonPath('data.0.name', 'Rick Sanchez');
        $response->assertJsonPath('data.0.status', 'Alive');

        // Inspect what query parameters were sent to the external API
        Http::assertSent(function ($request) {

            /**
             * @var string $base_url
             */
            $base_url = config('services.character_api_service.base_url');

            /**
             * @var Request $request
             */
            $request_url = $request->url();

            if (! str_starts_with($request_url, $base_url)) {
                return false;
            }

            return $request_url === $base_url.'?name=Rick&status=alive';
        });
    }
}
