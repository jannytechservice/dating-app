<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'conversation_id' => 'required|exists:conversations,id',
            'sender_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'conversation_id.required' => 'The conversation ID is required.',
            'conversation_id.exists' => 'The specified conversation does not exist.',
            'sender_id.required' => 'The sender ID is required.',
            'sender_id.exists' => 'The specified sender does not exist.',
            'message.required' => 'The message content is required.',
            'message.string' => 'The message content must be a valid string.',
            'message.max' => 'The message content must not exceed 5000 characters.',
        ];
    }
}
