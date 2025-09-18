<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateBookRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'isbn' => 'nullable|string|max:255|unique:books,isbn',
            'pages' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'language' => 'nullable|string|max:10',
            'publisher' => 'nullable|string|max:255',
            'cover' => 'nullable|string|max:255',
            'published_date' => 'nullable|date',
            'status' => 'nullable|string|in:available,borrowed,reserved',
        ];
    }

    /**
     * Agar validatsiya muvaffaqiyatsiz bo'lsa, JSON javob qaytaradi.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation error',
            'errors' => $validator->errors(),
        ], 422));
    }
}
