<?php
namespace App\Enums;

enum Status: int
{
    case Passive = 0;
    case Active = 1;

    public function name(): string
    {
        return match ($this) {
            self::Passive => 'Inactive',
            self::Active => 'Active',
        };
    }

    public static function toArray() : array
    {
        return collect(self::cases())->mapWithKeys(fn($value, $key) => [$key => $value->name()])->toArray();
    }
}
