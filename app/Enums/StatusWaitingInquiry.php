<?php
namespace App\Enums;

enum StatusWaitingInquiry: int
{
    case WAITING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
    case CANCELLED = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::WAITING => 'Waiting',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
            self::CANCELLED => 'Cancelled',
        };
    }
}
