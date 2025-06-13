<?php

namespace Tests\Unit\DTO;

use App\DTO\PaginationDTO;
use PHPUnit\Framework\TestCase;

class PaginationDTOTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function test_creating_instance_and_getters(): void
    {
        $count = 100;
        $pages = 5;
        $next = 'https://example.com/api?page=2';
        $prev = null;

        $pagination_dto = new PaginationDTO($count, $pages, $next, $prev);

        $this->assertEquals($count, $pagination_dto->getCount());
        $this->assertEquals($pages, $pagination_dto->getPages());
        $this->assertEquals($next, $pagination_dto->getNext());
        $this->assertEquals($prev, $pagination_dto->getPrev());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_to_array(): void
    {
        $count = 100;
        $pages = 5;
        $next = 'https://example.com/api?page=2';
        $prev = 'https://example.com/api?page=1';

        $pagination_dto = new PaginationDTO($count, $pages, $next, $prev);

        $array = $pagination_dto->toArray();

        $this->assertEquals(4, count($array));

        $this->assertEquals($count, $array['count']);
        $this->assertEquals($pages, $array['pages']);
        $this->assertEquals($next, $array['next']);
        $this->assertEquals($prev, $array['prev']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_from_array_with_valid_data(): void
    {
        $data = [
            'count' => 100,
            'pages' => 5,
            'next' => 'https://example.com/api?page=2',
            'prev' => 'https://example.com/api?page=1',
        ];

        $pagination_dto = PaginationDTO::fromArray($data);

        $this->assertEquals(100, $pagination_dto->getCount());
        $this->assertEquals(5, $pagination_dto->getPages());
        $this->assertEquals('https://example.com/api?page=2', $pagination_dto->getNext());
        $this->assertEquals('https://example.com/api?page=1', $pagination_dto->getPrev());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_from_array_with_missing_data(): void
    {
        $data = [];

        $pagination_dto = PaginationDTO::fromArray($data);

        $this->assertEquals(0, $pagination_dto->getCount());
        $this->assertEquals(0, $pagination_dto->getPages());
        $this->assertNull($pagination_dto->getNext());
        $this->assertNull($pagination_dto->getPrev());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_from_array_with_invalid_data_types(): void
    {
        $data = [
            'count' => '50abc', // Non-numeric count
            'pages' => [], // Array instead of numeric
            'next' => 123, // Number instead of string
            'prev' => new \stdClass, // Object instead of string
        ];

        $pagination_dto = PaginationDTO::fromArray($data);

        $this->assertEquals(0, $pagination_dto->getCount()); // Should default to 0 for invalid count
        $this->assertEquals(0, $pagination_dto->getPages()); // Should default to 0 for invalid pages
        $this->assertNull($pagination_dto->getNext()); // Should be null for non-string next
        $this->assertNull($pagination_dto->getPrev()); // Should be null for non-string prev
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_get_next_num(): void
    {
        $tests = [
            [
                'url' => 'https://example.com/api?page=2',
                'expected' => 2,
            ],
            [
                'url' => 'https://example.com/api?page=10&other=param',
                'expected' => 10,
            ],
            [
                'url' => 'https://example.com/api?other=param',
                'expected' => null,
            ],
            [
                'url' => null,
                'expected' => null,
            ],
            [
                'url' => 'https://example.com/api?page=invalid',
                'expected' => null,
            ],
        ];

        foreach ($tests as $test) {
            $pagination_dto = new PaginationDTO(100, 5, $test['url'], null);

            $this->assertEquals(
                $test['expected'],
                $pagination_dto->getNextNum(),
                'Failed extracting page number from: '.($test['url'] ?? 'null')
            );
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_get_prev_num(): void
    {
        $tests = [
            [
                'url' => 'https://example.com/api?page=1',
                'expected' => 1,
            ],
            [
                'url' => 'https://example.com/api?page=5&other=param',
                'expected' => 5,
            ],
            [
                'url' => 'https://example.com/api?other=param',
                'expected' => null,
            ],
            [
                'url' => null,
                'expected' => null,
            ],
        ];

        foreach ($tests as $test) {
            $pagination_dto = new PaginationDTO(100, 5, null, $test['url']);

            $this->assertEquals(
                $test['expected'],
                $pagination_dto->getPrevNum(),
                'Failed extracting page number from: '.($test['url'] ?? 'null')
            );
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function test_extract_page_from_url(): void
    {
        // Testing the static method directly

        // Valid URLs with page parameter
        $this->assertEquals(1, PaginationDTO::extractPageFromUrl('https://example.com/api?page=1'));
        $this->assertEquals(25, PaginationDTO::extractPageFromUrl('https://example.com/api?page=25&size=20'));
        $this->assertEquals(3, PaginationDTO::extractPageFromUrl('https://example.com/api?filter=active&page=3'));

        // URL with non-numeric page
        $this->assertNull(PaginationDTO::extractPageFromUrl('https://example.com/api?page=abc'));

        // URL without page parameter
        $this->assertNull(PaginationDTO::extractPageFromUrl('https://example.com/api?size=20'));

        // URL without query parameters
        $this->assertNull(PaginationDTO::extractPageFromUrl('https://example.com/api'));

        // Null URL
        $this->assertNull(PaginationDTO::extractPageFromUrl(null));

        // Empty URL
        $this->assertNull(PaginationDTO::extractPageFromUrl(''));
    }
}
