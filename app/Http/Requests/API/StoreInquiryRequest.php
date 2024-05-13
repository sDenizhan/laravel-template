<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreInquiryRequest extends FormRequest
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
            'treatment_id' => 'required|integer',
            'status' => 'required|integer',
            'gender' => 'required|integer',
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
            'country' => 'required|string',
            'ip_address' => 'required|string',
            'assignment_by' => 'required|integer',
            'assignment_to' => 'required|integer',
            'assignment_at' => 'required|date',
        ];
    }
}
