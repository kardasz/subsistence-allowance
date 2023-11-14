<?php

namespace App\SubsistenceAllowance\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\ValueObject\BusinessTripId;
use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Domain\ValueObject\Country;

class BusinessTripCreated extends DomainEvent
{
    public readonly BusinessTripId $businessTripId;
    public readonly EmployeeId $employeeId;
    public readonly Country $country;
    public readonly int $amountDue;
    public readonly \DateTimeImmutable $start;
    public readonly \DateTimeImmutable $end;

    public static function withData(
        BusinessTripId $businessTripId,
        EmployeeId $employeeId,
        Country $country,
        int $amountDue,
        \DateTimeImmutable $start,
        \DateTimeImmutable $end
    ): self {
        $event = new self((string) $businessTripId);
        $event->employeeId = $employeeId;
        $event->businessTripId = $businessTripId;
        $event->country = $country;
        $event->amountDue = $amountDue;
        $event->start = $start;
        $event->end = $end;

        return $event;
    }

    public function getEventData(): array
    {
        return [
            'employeeId' => $this->employeeId,
        ];
    }
}
