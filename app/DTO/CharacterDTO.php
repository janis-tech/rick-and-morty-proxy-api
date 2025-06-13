<?php

namespace App\DTO;

class CharacterDTO
{
    private int $id;

    private string $name;

    private string $status;

    private string $species;

    private string $type;

    private string $gender;

    /**
     * @var array<string, string> Character's origin with 'name' and 'url' keys
     */
    private array $origin;

    /**
     * @var array<string, string> Character's location with 'name' and 'url' keys
     */
    private array $location;

    private string $image;

    /**
     * @var array<int, string> List of episode URLs
     */
    private array $episode;

    private string $url;

    private string $created;

    /**
     * @param  array<string, string>  $origin
     * @param  array<string, string>  $location
     * @param  array<int, string>  $episode
     */
    public function __construct(
        int $id,
        string $name,
        string $status,
        string $species,
        string $type,
        string $gender,
        array $origin,
        array $location,
        string $image,
        array $episode,
        string $url,
        string $created
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->species = $species;
        $this->type = $type;
        $this->gender = $gender;
        $this->origin = $origin;
        $this->location = $location;
        $this->image = $image;
        $this->episode = $episode;
        $this->url = $url;
        $this->created = $created;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getSpecies(): string
    {
        return $this->species;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @return array<string, string>
     */
    public function getOrigin(): array
    {
        return $this->origin;
    }

    /**
     * @return array<string, string>
     */
    public function getLocation(): array
    {
        return $this->location;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @return array<int, string>
     */
    public function getEpisode(): array
    {
        return $this->episode;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'species' => $this->species,
            'type' => $this->type,
            'gender' => $this->gender,
            'origin' => $this->origin,
            'location' => $this->location,
            'image' => $this->image,
            'episode' => $this->episode,
            'url' => $this->url,
            'created' => $this->created,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        /** @var array<string, string> $origin */
        $origin = ['name' => '', 'url' => ''];
        if (isset($data['origin']) && is_array($data['origin'])) {
            $origin['name'] = isset($data['origin']['name']) && is_scalar($data['origin']['name'])
                ? (string) $data['origin']['name'] : '';
            $origin['url'] = isset($data['origin']['url']) && is_scalar($data['origin']['url'])
                ? (string) $data['origin']['url'] : '';
        }

        /** @var array<string, string> $location */
        $location = ['name' => '', 'url' => ''];
        if (isset($data['location']) && is_array($data['location'])) {
            $location['name'] = isset($data['location']['name']) && is_scalar($data['location']['name'])
                ? (string) $data['location']['name'] : '';
            $location['url'] = isset($data['location']['url']) && is_scalar($data['location']['url'])
                ? (string) $data['location']['url'] : '';
        }

        /** @var array<int, string> $episodes */
        $episodes = [];
        if (isset($data['episode']) && is_array($data['episode'])) {
            foreach ($data['episode'] as $url) {
                $episodes[] = is_scalar($url) ? (string) $url : '';
            }
        }

        return new self(
            isset($data['id']) && is_numeric($data['id']) ? (int) $data['id'] : 0,
            isset($data['name']) && is_scalar($data['name']) ? (string) $data['name'] : '',
            isset($data['status']) && is_scalar($data['status']) ? (string) $data['status'] : '',
            isset($data['species']) && is_scalar($data['species']) ? (string) $data['species'] : '',
            isset($data['type']) && is_scalar($data['type']) ? (string) $data['type'] : '',
            isset($data['gender']) && is_scalar($data['gender']) ? (string) $data['gender'] : '',
            $origin,
            $location,
            isset($data['image']) && is_scalar($data['image']) ? (string) $data['image'] : '',
            $episodes,
            isset($data['url']) && is_scalar($data['url']) ? (string) $data['url'] : '',
            isset($data['created']) && is_scalar($data['created']) ? (string) $data['created'] : ''
        );
    }
}
