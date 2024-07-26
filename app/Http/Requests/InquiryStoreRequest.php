<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InquiryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'country' => 'required',
            'surname' => 'required',
            'phone' => 'required',
            'ip_address' => 'nullable',
            'treatment_id' => 'required|exists:treatments,id',
            'language_id' => 'required|exists:languages,id',
            'coordinator_id' => 'required|exists:users,id',
            'message' => 'nullable',
            'id' => 'required|exists:inquiries,id'
        ];
    }
}
