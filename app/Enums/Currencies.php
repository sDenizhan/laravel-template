<?php
namespace App\Enums;

enum Currencies: int
{
    case EUR = 0;
    case USD = 1;
    case GBP = 2;

    public function name(): string
    {
        return match ($this) {
            self::EUR => 'EUR',
            self::USD => 'USD',
            self::GBP => 'GBP'
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn($value, $key) => [$key => $value->name()])->toArray();
    }
}
