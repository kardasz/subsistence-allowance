<?php

namespace App\Shared\Infrastructure\Doctrine\DBAL\Types;

use App\Shared\Domain\ValueObject\BusinessTripId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

class BusinessTripIdType extends AbstractUidType
{
    public const NAME = 'business_trip_id';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getUidClass(): string
    {
        return BusinessTripId::class;
    }
}
