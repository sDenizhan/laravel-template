<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalFormQuestionRequest extends FormRequest
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
            'medical_form_id' => 'required|integer',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'rules' => 'nullable|string',
            'order' => 'required|integer',
        ];
    }
}
