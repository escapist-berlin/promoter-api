<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrUpdatePromoterGroupRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'skill_ids' => 'nullable|array',
            'skill_ids.*' => 'exists:skills,id',
            'promoter_ids' => 'nullable|array',
            'promoter_ids.*' => 'exists:promoters,id',
        ];
    }

    /**
     * Handle failed validation and return a JSON response with errors.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $errors
            ], 422)
        );
    }
}