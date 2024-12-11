<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConversationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'type' => 'required|in:private,group',
            'name' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'The conversation type is required.',
            'type.in' => 'The conversation type must be either "private" or "group".',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name must not exceed 255 characters.',
        ];
    }
}
