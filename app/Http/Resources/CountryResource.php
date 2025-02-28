<?php
namespace App\Http\Resources;

use App\Repositories\CountryRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray($request)
    {
        $translations = [];
        foreach ($this->translations as $translation) {
            $translations[$translation->locale] = $translation->name;
        }

        return [
            'id' => $this->id,
            'code' => $this->code,
            'code_alpha3' => $this->code_alpha3,
            'phone_code' => $this->phone_code,
            'name' => $translations
        ];

    }
}
