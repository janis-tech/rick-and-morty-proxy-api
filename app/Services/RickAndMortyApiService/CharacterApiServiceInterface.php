<?php

namespace App\Services\RickAndMortyApiService;

use App\DTO\CharacterDTO;
use App\DTO\CharacterResponseDTO;

interface CharacterApiServiceInterface
{
    /**
     * Get all characters.
     *
     * @param  int  $page  The page number to retrieve.
     * @param  array<mixed>|null  $filters  Optional filters for the character search.
     */
    public function getAllCharacters(int $page, ?array $filters): CharacterResponseDTO;

    /**
     * Get a character by ID.
     */
    public function getCharacterById(int $id): ?CharacterDTO;
}
