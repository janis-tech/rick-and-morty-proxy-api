<?php

namespace App\Services\RickAndMortyApiService;

use App\DTO\CharacterDTO;
use App\DTO\CharacterResponseDTO;
use App\DTO\PaginationDTO;
use App\Exceptions\CharacterNotFoundException;
use Illuminate\Support\Facades\Http;

class RickAndMortyApiService implements CharacterApiServiceInterface
{
    protected string $base_url;

    public function __construct()
    {

        $base_url = config('services.character_api_service.base_url', '');
        if (! is_string($base_url) || strlen($base_url) === 0) {
            throw new \InvalidArgumentException('Base URL for Character API Service is not set in configuration.');
        }

        $this->base_url = $base_url;

        if (empty($this->base_url)) {
            throw new \InvalidArgumentException('Base URL for Character API Service is not set in configuration.');
        }
    }

    /**
     * Get all characters.
     *
     * @param  int  $page  The page number to retrieve.
     * @param  array<string, mixed>|null  $filters  Optional filters for the character search.
     */
    public function getAllCharacters(int $page, ?array $filters): CharacterResponseDTO
    {
        if ($page > 1) {
            $filters['page'] = $page;
        }

        $response_data = $this->makeRequest($this->base_url, $filters);

        $characters = [];
        $pagination = null;

        /** @var array<string, mixed> $response_data */
        if (isset($response_data['results']) && is_array($response_data['results'])) {
            foreach ($response_data['results'] as $character_data) {
                /** @var array<string, mixed> $character_data */
                $characters[] = CharacterDTO::fromArray($character_data);
            }
        }

        if (isset($response_data['info']) && is_array($response_data['info'])) {
            /** @var array<string, mixed> $info */
            $info = $response_data['info'];
            $pagination = PaginationDTO::fromArray($info);
        }

        return new CharacterResponseDTO($characters, $pagination);
    }

    /**
     * Get a character by ID.
     */
    public function getCharacterById(int $id): ?CharacterDTO
    {
        $url = $this->base_url.$id;

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
            match ($response->getStatusCode()) {
                404 => throw new CharacterNotFoundException('Character not found'),
                default => throw new \Exception('Unexpected error occurred'),
            };
        }

        /**
         * @var array<string, mixed> $response
         */
        $response = $response->json();

        return $response;
    }
}
