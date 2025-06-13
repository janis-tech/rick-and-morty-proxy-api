<?php

namespace Tests\Helpers;

use Illuminate\Support\Facades\Http;

trait MocksRickAndMortyApi
{
    /**
     * Get a complete mock character data array.
     *
     * @param  int  $id  The character ID
     * @return array<string, mixed>
     */
    protected function getMockCharacterData(int $id = 1): array
    {
        return [
            'id' => $id,
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'type' => '',
            'gender' => 'Male',
            'origin' => [
                'name' => 'Earth (C-137)',
                'url' => 'https://rickandmortyapi.com/api/location/1',
            ],
            'location' => [
                'name' => 'Citadel of Ricks',
                'url' => 'https://rickandmortyapi.com/api/location/3',
            ],
            'image' => 'https://rickandmortyapi.com/api/character/avatar/1.jpeg',
            'episode' => [
                'https://rickandmortyapi.com/api/episode/1',
                'https://rickandmortyapi.com/api/episode/2',
            ],
            'url' => 'https://rickandmortyapi.com/api/character/'.$id,
            'created' => '2017-11-04T18:48:46.250Z',
        ];
    }

    /**
     * Mock the Rick and Morty API to return a list of characters.
     *
     * @param  int  $count  Number of characters to include
     * @param  int  $pages  Number of pages
     */
    protected function mockCharactersList(int $count = 1, int $pages = 1): void
    {
        /**
         * @var string $base_url
         */
        $base_url = config('services.character_api_service.base_url');

        $characters = [];
        for ($i = 1; $i <= $count; $i++) {
            $characters[] = $this->getMockCharacterData($i);
        }

        Http::fake([
            $base_url => Http::response([
                'results' => $characters,
                'info' => [
                    'count' => count($characters),
                    'pages' => $pages,
                    'next' => $pages > 1 ? $base_url.'?page=2' : null,
                    'prev' => null,
                ],
            ], 200),

            // Handle filtered requests
            "{$base_url}*" => function ($request) {
                return Http::response([
                    'results' => [
                        $this->getMockCharacterData(),
                    ],
                    'info' => [
                        'count' => 1,
                        'pages' => 1,
                        'next' => null,
                        'prev' => null,
                    ],
                ], 200);
            },
        ]);
    }

    /**
     * Mock the Rick and Morty API to return a single character by ID.
     *
     * @param  int  $id  The character ID
     * @param  bool  $exists  Whether the character exists
     */
    protected function mockCharacterById(int $id, bool $exists = true): void
    {
        /**
         * @var string $base_url
         */
        $base_url = config('services.character_api_service.base_url');

        if ($exists) {
            Http::fake([
                "{$base_url}{$id}" => Http::response($this->getMockCharacterData($id), 200),
            ]);
        } else {
            Http::fake([
                "{$base_url}{$id}" => Http::response([
                    'error' => 'Character not found',
                ], 404),
            ]);
        }
    }

    /**
     * Mock the Rick and Morty API to simulate server errors.
     */
    protected function mockServerError(): void
    {
        /**
         * @var string $base_url
         */
        $base_url = config('services.character_api_service.base_url');
        Http::fake([
            "{$base_url}*" => Http::response([
                'error' => 'Server error',
            ], 500),
        ]);
    }
}
