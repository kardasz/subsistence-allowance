<?php

namespace App\SubsistenceAllowance\Domain\ValueObject;

use App\SubsistenceAllowance\Domain\Exception\InvalidCountryException;

enum Country: string
{
    case PL = 'PL';
    case DE = 'DE';
    case GB = 'GB';

    public static function fromString(string $country): self
    {
        $result = self::tryFrom($country);
        if (null == $result) {
            throw new InvalidCountryException($country);
        }

        return $result;
    }
}
