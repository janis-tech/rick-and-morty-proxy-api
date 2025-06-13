<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacterIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:alive,dead,unknown',
            'page' => 'nullable|integer|min:1'
        ];
    }

    /**
     * Summary of queryParameters
     *
     * @return array<mixed>
     */
    public function queryParameters(): array
    {
        return [
            'name' => [
                'description' => 'The name of the character to search for.',
                'example' => 'Rick Sanchez',
            ],
            'status' => [
                'description' => 'The status of the character.',
                'example' => 'alive',
                'enum' => ['alive', 'dead', 'unknown'],
            ],
            'page'=> [
                'description' => 'The page number to retrieve.',
                'example' => 1,
            ]
        ];
    }
}
