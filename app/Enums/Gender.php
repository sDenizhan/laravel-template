<?php
namespace App\Enums;

enum Gender: int
{
    case None = 0;
    case Male = 1;
    case Female = 2;

    public function name(): string
    {
        return match ($this) {
            self::None => 'None',
            self::Male => 'Male',
            self::Female => 'Female'
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn($value, $key) => [$key => $value->name()])->toArray();
    }
}
