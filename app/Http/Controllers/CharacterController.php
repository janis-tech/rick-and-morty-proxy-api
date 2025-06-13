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
        $characters = [];
        $filters = $request->validated();

        try {
            $characters = $this->characterApiService->getAllCharacters(15, $filters);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to retrieve characters: '.$e->getMessage(),
                ],
                500
            );
        }

        $character_data = array_map(function (CharacterDTO $character) {
            return $character->toArray();
        }, $characters);

        return response()->json(
            [
                'status' => 'success',
                'data' => $character_data,
                'message' => 'Characters retrieved successfully.',
                'pagination' => [
                    'total' => count($characters),
                    'count' => count($characters),
                    'per_page' => 10,
                    'current_page' => 1,
                    'total_pages' => 1,
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
