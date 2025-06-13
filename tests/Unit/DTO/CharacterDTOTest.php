<?php

namespace Tests\Unit\DTO;

use App\DTO\CharacterDTO;
use PHPUnit\Framework\TestCase;

class CharacterDTOTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function test_creating_instance_and_getters(): void
    {
        $id = 1;
        $name = 'Rick Sanchez';
        $status = 'Alive';
        $species = 'Human';
        $type = 'Scientist';
        $gender = 'Male';
        $origin = ['name' => 'Earth', 'url' => 'https://example.com/earth'];
        $location = ['name' => 'Citadel of Ricks', 'url' => 'https://example.com/citadel'];
        $image = 'https://example.com/rick.jpg';
        $episode = ['https://example.com/ep1', 'https://example.com/ep2'];
        $url = 'https://example.com/character/1';
        $created = '2023-06-14T12:00:00.000Z';

        $character_dto = new CharacterDTO(
            $id,
            $name,
            $status,
            $species,
            $type,
            $gender,
            $origin,
            $location,
            $image,
            $episode,
            $url,
            $created
        );

        $this->assertEquals($id, $character_dto->getId());
        $this->assertEquals($name, $character_dto->getName());
        $this->assertEquals($status, $character_dto->getStatus());
        $this->assertEquals($species, $character_dto->getSpecies());
        $this->assertEquals($type, $character_dto->getType());
        $this->assertEquals($gender, $character_dto->getGender());
        $this->assertEquals($origin, $character_dto->getOrigin());
        $this->assertEquals($location, $character_dto->getLocation());
        $this->assertEquals($image, $character_dto->getImage());
        $this->assertEquals($episode, $character_dto->getEpisode());
        $this->assertEquals($url, $character_dto->getUrl());
        $this->assertEquals($created, $character_dto->getCreated());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_to_array(): void
    {
        $character_dto = new CharacterDTO(
            1,
            'Rick Sanchez',
            'Alive',
            'Human',
            'Scientist',
            'Male',
            ['name' => 'Earth', 'url' => 'https://example.com/earth'],
            ['name' => 'Citadel of Ricks', 'url' => 'https://example.com/citadel'],
            'https://example.com/rick.jpg',
            ['https://example.com/ep1', 'https://example.com/ep2'],
            'https://example.com/character/1',
            '2023-06-14T12:00:00.000Z'
        );

        $array = $character_dto->toArray();

        $this->assertEquals(12, count($array));

        $this->assertEquals(1, $array['id']);
        $this->assertEquals('Rick Sanchez', $array['name']);
        $this->assertEquals('Alive', $array['status']);
        $this->assertEquals('Human', $array['species']);
        $this->assertEquals('Scientist', $array['type']);
        $this->assertEquals('Male', $array['gender']);
        $this->assertEquals(['name' => 'Earth', 'url' => 'https://example.com/earth'], $array['origin']);
        $this->assertEquals(['name' => 'Citadel of Ricks', 'url' => 'https://example.com/citadel'], $array['location']);
        $this->assertEquals('https://example.com/rick.jpg', $array['image']);
        $this->assertEquals(['https://example.com/ep1', 'https://example.com/ep2'], $array['episode']);
        $this->assertEquals('https://example.com/character/1', $array['url']);
        $this->assertEquals('2023-06-14T12:00:00.000Z', $array['created']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_from_array_with_valid_data(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Rick Sanchez',
            'status' => 'Alive',
            'species' => 'Human',
            'type' => 'Scientist',
            'gender' => 'Male',
            'origin' => ['name' => 'Earth', 'url' => 'https://example.com/earth'],
            'location' => ['name' => 'Citadel of Ricks', 'url' => 'https://example.com/citadel'],
            'image' => 'https://example.com/rick.jpg',
            'episode' => ['https://example.com/ep1', 'https://example.com/ep2'],
            'url' => 'https://example.com/character/1',
            'created' => '2023-06-14T12:00:00.000Z',
        ];

        $character_dto = CharacterDTO::fromArray($data);

        $this->assertEquals(1, $character_dto->getId());
        $this->assertEquals('Rick Sanchez', $character_dto->getName());
        $this->assertEquals('Alive', $character_dto->getStatus());
        $this->assertEquals('Human', $character_dto->getSpecies());
        $this->assertEquals('Scientist', $character_dto->getType());
        $this->assertEquals('Male', $character_dto->getGender());
        $this->assertEquals(['name' => 'Earth', 'url' => 'https://example.com/earth'], $character_dto->getOrigin());
        $this->assertEquals(['name' => 'Citadel of Ricks', 'url' => 'https://example.com/citadel'], $character_dto->getLocation());
        $this->assertEquals('https://example.com/rick.jpg', $character_dto->getImage());
        $this->assertEquals(['https://example.com/ep1', 'https://example.com/ep2'], $character_dto->getEpisode());
        $this->assertEquals('https://example.com/character/1', $character_dto->getUrl());
        $this->assertEquals('2023-06-14T12:00:00.000Z', $character_dto->getCreated());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_from_array_with_missing_data(): void
    {
        $data = [
            'id' => 42,
            'name' => 'Morty Smith',
        ];

        $character_dto = CharacterDTO::fromArray($data);

        $this->assertEquals(42, $character_dto->getId());
        $this->assertEquals('Morty Smith', $character_dto->getName());
        $this->assertEquals('', $character_dto->getStatus());
        $this->assertEquals('', $character_dto->getSpecies());
        $this->assertEquals('', $character_dto->getType());
        $this->assertEquals('', $character_dto->getGender());
        $this->assertEquals(['name' => '', 'url' => ''], $character_dto->getOrigin());
        $this->assertEquals(['name' => '', 'url' => ''], $character_dto->getLocation());
        $this->assertEquals('', $character_dto->getImage());
        $this->assertEquals([], $character_dto->getEpisode());
        $this->assertEquals('', $character_dto->getUrl());
        $this->assertEquals('', $character_dto->getCreated());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_from_array_with_invalid_data_types(): void
    {
        $data = [
            'id' => '123abc', // Non-numeric ID
            'name' => 123, // Numeric name
            'status' => new \stdClass, // Object where string expected
            'origin' => 'Not an array', // String where array expected
            'episode' => ['valid', new \stdClass, 123], // Mixed types in episode array
        ];

        $character_dto = CharacterDTO::fromArray($data);

        $this->assertEquals(0, $character_dto->getId()); // Should default to 0 for invalid ID
        $this->assertEquals('123', $character_dto->getName()); // Should convert to string
        $this->assertEquals('', $character_dto->getStatus()); // Should default to empty string for invalid object
        $this->assertEquals(['name' => '', 'url' => ''], $character_dto->getOrigin()); // Should use default array

        $episodes = $character_dto->getEpisode();
        $this->assertCount(3, $episodes);
        $this->assertEquals('valid', $episodes[0]);
    }
}
