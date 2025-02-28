<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InquiryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'treatment' => $this->treatment->name,
            'treatment_id' => $this->treatment_id,
            'language' => $this->language->name,
            'language_id' => $this->language_id,
            'reference_user' => $this->reference->name,
            'reference_user_id' => $this->reference_user_id,
            'status' => $this->status,
            'coordinator' => $this->coordinator,
            'answers' => $this->answers,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
        ];
    }
}
