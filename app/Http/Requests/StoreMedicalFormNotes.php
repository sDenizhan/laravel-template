<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalFormNotes extends FormRequest
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
            'inquiry_id' => 'required|exists:inquiries,id',
            'answer_id' => 'required|exists:medical_form_patient_answers,id',
            'user_id' => 'required|exists:users,id',
            'notes' => 'required|string',
        ];
    }
}
