<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalFormRequest extends FormRequest
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
            'treatment_id' => 'required|exists:treatments,id',
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'settings' => 'nullable|array',
        ];
    }
}
