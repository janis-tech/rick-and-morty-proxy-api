<?php

namespace App\Services\RickAndMortyApiService;

use App\DTO\CharacterDTO;
use Illuminate\Support\Facades\Http;

class RickAndMortyApiService implements CharacterApiServiceInterface
{
    protected string $baseUrl = 'https://rickandmortyapi.com/api/character/';

    /**
     * Get all characters.
     *
     * @param  int  $page  The page number to retrieve.
     * @param  array<string, mixed>|null  $filters  Optional filters for the character search.
     * @return array<CharacterDTO>
     */
    public function getAllCharacters(int $page, ?array $filters): array
    {

        if ($page > 1) {
            $filters['page'] = $page;
        }

        $response_data = $this->makeRequest($this->baseUrl, $filters);

        $characters = [];

        /** @var array<string, mixed> $response_data */
        if (isset($response_data['results']) && is_array($response_data['results'])) {
            foreach ($response_data['results'] as $character_data) {
                /** @var array<string, mixed> $character_data */
                $characters[] = CharacterDTO::fromArray($character_data);
            }
        }

        return $characters;
    }

    /**
     * Get a character by ID.
     */
    public function getCharacterById(int $id): ?CharacterDTO
    {
        $url = $this->baseUrl.$id;

        try {
            $character_data = $this->makeRequest($url, null);

            /** @var array<string, mixed> $character_data */
            return CharacterDTO::fromArray($character_data);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Make a request to the Rick and Morty API.
     *
     * @param  array<string, mixed>|null  $params
     * @return array <string, mixed>
     *
     * @throws \Exception
     */
    private function makeRequest(string $url, ?array $params): array
    {

        if ($params === null) {
            $params = [];
        }

        $response = Http::get($url, $params);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch data from Rick and Morty API');
        }

        /**
         * @var array<string, mixed> $response
         */
        $response = $response->json();

        return $response;
    }
}
