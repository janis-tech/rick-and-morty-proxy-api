<?php

namespace App\Http\Controllers;

use App\DTO\CharacterDTO;
use App\Http\Requests\CharacterIndexRequest;
use App\Services\RickAndMortyApiService\CharacterApiServiceInterface;
use Illuminate\Http\JsonResponse;

class CharacterController extends Controller
{
    private CharacterApiServiceInterface $characterApiService;

    public function __construct(CharacterApiServiceInterface $characters)
    {
        $this->characterApiService = $characters;
    }

    /**
     * Display a character listing.
     */
    public function index(CharacterIndexRequest $request): JsonResponse
    {
        $character_response = null;
        $filters = $request->filters();
        $page = $request->integer('page', 1);

        try {
            $character_response = $this->characterApiService->getAllCharacters($page, $filters);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to retrieve characters: '.$e->getMessage(),
                ],
                500
            );
        }

        $characters = $character_response->getCharacters();
        $pagination = $character_response->getPagination();

        $character_data = array_map(function (CharacterDTO $character) {
            return $character->toArray();
        }, $characters);

        return response()->json(
            [
                'status' => 'success',
                'data' => $character_data,
                'message' => 'Characters retrieved successfully.',
                'pagination' => [
                    'total' => $pagination ? $pagination->getCount() : 0,
                    'pages' => $pagination ? $pagination->getPages() : 0,
                    'next_page' => $pagination ? $pagination->getNextNum() : null,
                    'prev_page' => $pagination ? $pagination->getPrevNum() : null,
                    'current_page' => $page,
                    'count' => count($character_data),
                ],
            ],
            200
        );
    }

    /**
     * Display a specific character by ID.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $character = $this->characterApiService->getCharacterById((int) $id);

            if (! $character) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Character not found',
                    ],
                    404
                );
            }

            return response()->json(
                [
                    'status' => 'success',
                    'data' => $character->toArray(),
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to retrieve character: '.$e->getMessage(),
                ],
                500
            );
        }
    }
}
