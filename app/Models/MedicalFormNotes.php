<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalFormNotes extends Model
{
    use HasFactory;

    protected $table = 'medical_forms_notes';

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function medicalform(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MedicalForm::class, 'medical_form_id');
    }

    public function answers()
    {
        return $this->hasMany(MedicalFormPatientAnswers::class, 'medical_form_note_id');
    }
}
