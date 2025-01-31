<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'country_id',
        'locale',
        'name'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
