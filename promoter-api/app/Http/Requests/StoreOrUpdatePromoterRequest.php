<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdatePromoterRequest extends FormRequest
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
        $promoterId = $this->route('promoter') ? $this->route('promoter')->id : null;

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthday_date' => 'required|date|before:today',
            'gender' => 'required|string|in:male,female,other',
            'email' => 'required|email|unique:promoters,email,' . $promoterId,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'availabilities' => 'nullable|array',
            'availabilities.*' => 'string|max:255',
        ];
    }
}
