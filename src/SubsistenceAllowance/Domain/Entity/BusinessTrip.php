<?php

namespace App\SubsistenceAllowance\Domain\Entity;

use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\BusinessTripId;
use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Domain\Event\BusinessTripCreated;
use App\SubsistenceAllowance\Domain\ValueObject\Country;

class BusinessTrip extends AggregateRoot
{
    public readonly BusinessTripId $businessTripId;
    public readonly EmployeeId $employeeId;
    public readonly Country $country;
    public readonly int $amountDue;
    public readonly \DateTimeImmutable $start;
    public readonly \DateTimeImmutable $end;

    public static function createNew(
        BusinessTripId $businessTripId,
        EmployeeId $employeeId,
        Country $country,
        int $amountDue,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end
    ): self {
        $businessTrip = new self();
        $businessTrip->recordThat(BusinessTripCreated::withData(
            businessTripId: $businessTripId,
            employeeId: $employeeId,
            country: $country,
            amountDue: $amountDue,
            start: $start,
            end: $end
        ));

        return $businessTrip;
    }

    public function whenBusinessTripCreated(BusinessTripCreated $businessTripCreated): void
    {
        $this->businessTripId = $businessTripCreated->businessTripId;
        $this->employeeId = $businessTripCreated->employeeId;
        $this->country = $businessTripCreated->country;
        $this->amountDue = $businessTripCreated->amountDue;
        $this->start = $businessTripCreated->start;
        $this->end = $businessTripCreated->end;
    }
}
