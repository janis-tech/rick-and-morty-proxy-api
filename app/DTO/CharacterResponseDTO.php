<?php

namespace App\DTO;

class CharacterResponseDTO
{
    /**
     * @var array<CharacterDTO>
     */
    private array $characters;

    private ?PaginationDTO $pagination;

    /**
     * @param  array<CharacterDTO>  $characters
     */
    public function __construct(array $characters, ?PaginationDTO $pagination)
    {
        $this->characters = $characters;
        $this->pagination = $pagination;
    }

    /**
     * @return array<CharacterDTO>
     */
    public function getCharacters(): array
    {
        return $this->characters;
    }

    public function getPagination(): ?PaginationDTO
    {
        return $this->pagination;
    }
}
