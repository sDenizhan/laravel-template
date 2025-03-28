<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFormPatientAnswers extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $casts = [
        'answers' => 'array'
    ];

    public function medicalform()
    {
        return $this->belongsTo(MedicalForm::class, 'medical_form_id');
    }

}
