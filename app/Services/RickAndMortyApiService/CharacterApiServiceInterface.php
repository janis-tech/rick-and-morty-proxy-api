<?php

namespace App\Services\RickAndMortyApiService;

use App\DTO\CharacterDTO;

interface CharacterApiServiceInterface
{
    /**
     * Get all characters.
     *
     * @param  int  $page  The page number to retrieve.
     * @param  array<mixed>|null  $filters  Optional filters for the character search.
     * @return array<CharacterDTO>
     */
    public function getAllCharacters(int $page, ?array $filters): array;

    /**
     * Get a character by ID.
     */
    public function getCharacterById(int $id): ?CharacterDTO;
}
