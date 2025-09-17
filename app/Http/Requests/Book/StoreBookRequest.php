<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:13|unique:books,isbn',
            'pages' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'language' => 'nullable|string|max:10',
            'publisher' => 'nullable|string|max:255',
            'cover' => 'required|string|max:255',
            'published_date' => 'nullable|date',
            'status' => 'nullable|string|in:available,borrowed,reserved',
        ];
    }
}
