<?php
namespace App\Enums;

enum Airports: int
{
    case Istanbul = 0;
    case SabihaGokcen = 1;

    public function name(): string
    {
        return match ($this) {
            self::Istanbul => 'Istanbul Airport',
            self::SabihaGokcen => 'Sabiha Gokcen Airport',
        };
    }

    public static function toArray(): array
    {
        return collect(self::cases())->mapWithKeys(fn($value, $key) => [$key => $value->name()])->toArray();
    }
}
