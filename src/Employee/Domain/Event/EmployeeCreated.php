<?php

declare(strict_types=1);

namespace App\Employee\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\Shared\Domain\ValueObject\EmployeeId;

class EmployeeCreated extends DomainEvent
{
    public readonly EmployeeId $employeeId;

    public static function withData(EmployeeId $employeeId): self
    {
        $event = new self((string) $employeeId);
        $event->employeeId = $employeeId;

        return $event;
    }

    public function getEventData(): array
    {
        return [
            'employeeId' => $this->employeeId,
        ];
    }
}
