<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFundRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'start_year' => ['required', 'integer', 'digits:4'],
            'fund_manager_id' => ['required', 'exists:fund_managers,id'],
            'aliases' => ['nullable', 'array'],
            'aliases.*' => ['string', 'max:255']
        ];
    }
}
