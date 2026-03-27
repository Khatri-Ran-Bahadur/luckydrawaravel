<?php

namespace App\Enums;

enum WalletStatusEnum: string
{
    case ACTIVE = 'active';
    case BLOCKED = 'blocked';
    case SUSPENDED = 'suspended';

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
            self::BLOCKED => __('Blocked'),
            self::SUSPENDED => __('Suspended'),
        };
    }
}
