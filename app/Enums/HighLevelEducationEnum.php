<?php

namespace App\Enums;

enum HighLevelEducationEnum: string
{
    case HIGH_SCHOOL = 'high school';
    case BACHELORS = 'bachelor';
    case MASTERS = 'master';
    case PG = 'pg';
    case PHD = 'phd';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::HIGH_SCHOOL => 'High School',
            self::BACHELORS => 'Bachelors',
            self::MASTERS => 'Masters',
            self::PG => 'Pg',
            self::PHD => 'Phd',
        };
    }
}
