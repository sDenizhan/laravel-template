<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    public $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function treatment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Treatments::class, 'treatment_id', 'id');
    }

    public function coordinator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'assigment_to', 'id');
    }


}
