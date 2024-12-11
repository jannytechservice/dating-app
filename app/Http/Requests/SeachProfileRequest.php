<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeachProfileRequest extends FormRequest
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
            'query' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'query.string' => 'The search query must be a valid string.',
            'query.max' => 'The search query must not exceed 255 characters.',
        ];
    }
}
