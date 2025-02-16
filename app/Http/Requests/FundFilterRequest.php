<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FundFilterRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'fund_manager' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'integer', 'digits:4'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'The name must be a valid string.',
            'fund_manager.string' => 'The fund manager must be a valid string.',
            'year.integer' => 'The year must be a valid number.',
            'year.digits' => 'The year must be a four-digit number.',
        ];
    }
}
