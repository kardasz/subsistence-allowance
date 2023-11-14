<?php

namespace App\SubsistenceAllowance\Domain\ValueObject;

enum Rate: int
{
    case PL = 10;
    case DE = 50;
    case GB = 75;

    public static function byCountry(Country $country): self
    {
        return match ($country) {
            Country::PL => self::PL,
            Country::DE => self::DE,
            Country::GB => self::GB
        };
    }
}
