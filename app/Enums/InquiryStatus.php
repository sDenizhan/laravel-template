<?php
namespace App\Enums;

enum InquiryStatus: int
{
    case WAITING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case CANCELLED = 3;
    case NOT_REACHED = 4;
    case GIVE_UP = 5;
    case FORM_SENT = 6;
    case FORM_RECEIVED = 7;
    case ANESTHESIA_SENT = 8;
    case ANESTHESIA_ACCEPTED = 9;
    case ANESTHESIA_REJECTED = 10;
    case DOCTOR_SENT = 11;
    case DOCTOR_ACCEPTED = 12;
    case DOCTOR_REJECTED = 13;
    case PLANNED = 14;
    case WAITING_PATIENT_ARRIVE = 15;
    case PATIENT_IN_HOSPITAL = 16;
    case WAITING_PATIENT_LEAVE = 17;
    case OPERATION_DONE = 18;

    public function getLabel(): string
    {
        return match ($this) {
            self::WAITING => 'Waiting',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
            self::NOT_REACHED => 'Not reached',
            self::GIVE_UP => 'Give up',
            self::FORM_SENT => 'Form sent',
            self::FORM_RECEIVED => 'Form received',
            self::ANESTHESIA_SENT => 'Anesthesia sent',
            self::ANESTHESIA_ACCEPTED => 'Anesthesia accepted',
            self::ANESTHESIA_REJECTED => 'Anesthesia rejected',
            self::DOCTOR_SENT => 'Doctor sent',
            self::DOCTOR_ACCEPTED => 'Doctor accepted',
            self::DOCTOR_REJECTED => 'Doctor rejected',
            self::PLANNED => 'Planned',
            self::WAITING_PATIENT_ARRIVE => 'Waiting patient arrive',
            self::PATIENT_IN_HOSPITAL => 'Patient in hospital',
            self::WAITING_PATIENT_LEAVE => 'Waiting patient leave',
            self::OPERATION_DONE => 'Operation done',
        };
    }
}
