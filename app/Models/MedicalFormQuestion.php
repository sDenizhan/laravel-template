<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalFormQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'rules' => 'array',
    ];

    public function medicalForm(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MedicalForm::class, 'medical_form_id', 'id');
    }

    public function answers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MedicalFormQuestionAnswer::class, 'medical_form_question_id', 'id');
    }
}
