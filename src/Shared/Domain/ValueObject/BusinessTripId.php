<?php

namespace App\Shared\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

class BusinessTripId extends Uuid implements \Stringable
{
    public static function generate(): self
    {
        return new self((string) self::v4());
    }
}
