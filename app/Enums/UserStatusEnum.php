<?php

namespace App\Enums;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BANNED = 'banned';

    public static function values(): array
    {
        return array_map(fn($status) => $status->value, self::cases());
    }

    public static function default(): self
    {
        return self::ACTIVE;
    }

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => __('Active'),
            self::INACTIVE => __('Inactive'),
            self::BANNED => __('Banned'),
        };
    }
}
