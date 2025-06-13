<?php

namespace App\DTO;

class PaginationDTO
{
    private int $count;

    private int $pages;

    private ?string $next;

    private ?string $prev;

    public function __construct(int $count, int $pages, ?string $next, ?string $prev)
    {
        $this->count = $count;
        $this->pages = $pages;
        $this->next = $next;
        $this->prev = $prev;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPages(): int
    {
        return $this->pages;
    }

    public function getNext(): ?string
    {
        return $this->next;
    }

    public function getPrev(): ?string
    {
        return $this->prev;
    }

    public function getNextNum(): ?int
    {
        return self::extractPageFromUrl($this->next);
    }

    public function getPrevNum(): ?int
    {
        return self::extractPageFromUrl($this->prev);
    }

    /**
     * Extract page number from URL
     */
    public static function extractPageFromUrl(?string $url): ?int
    {
        if ($url === null) {
            return null;
        }

        $parsed_url = parse_url($url);
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $query_params);
            if (isset($query_params['page']) && is_numeric($query_params['page'])) {
                return (int) $query_params['page'];
            }
        }

        return null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'pages' => $this->pages,
            'next' => $this->next,
            'prev' => $this->prev,
        ];
    }

    /**
     * Create a PaginationDTO from an array
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['count']) && is_numeric($data['count']) ? (int) $data['count'] : 0,
            isset($data['pages']) && is_numeric($data['pages']) ? (int) $data['pages'] : 0,
            isset($data['next']) && is_string($data['next']) ? $data['next'] : null,
            isset($data['prev']) && is_string($data['prev']) ? $data['prev'] : null
        );
    }
}
