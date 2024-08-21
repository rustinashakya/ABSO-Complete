<?php

namespace App\Enums;

enum TeamTypeEnum: string
{
    case GENERAL = 'general';
    case EXPERT = 'expert';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self:: GENERAL=> 'General',
            self::EXPERT => 'Expert',
        };
    }
}
