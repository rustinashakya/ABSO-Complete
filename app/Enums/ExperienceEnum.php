<?php

namespace App\Enums;

enum ExperienceEnum: string
{
    case LESS_THAN_ONE_YEAR = 'less than 1 year';
    case ONE_TO_TWO_YEARS = '1 to 2 years';
    case TWO_TO_FIVE_YEARS = '2 to 5 years';
    case FIVE_TO_TEN_YEARS = '5 to 10 years';
    case MORE_THAN_TEN_YEARS = 'more than 10 years';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::LESS_THAN_ONE_YEAR => 'Less than 1 year',
            self::ONE_TO_TWO_YEARS => '1 to 2 years',
            self::TWO_TO_FIVE_YEARS => '2 to 5 years',
            self::FIVE_TO_TEN_YEARS => '5 to 10 years',
            self::MORE_THAN_TEN_YEARS => 'More than 10 years',
        };
    }
}
