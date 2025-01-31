<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'code_alpha3',
        'phone_code',
        'is_active'
    ];

    public function translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->translations->where('locale', $locale)->first()->name ?? 
               $this->translations->where('locale', 'en')->first()->name;
    }
}
