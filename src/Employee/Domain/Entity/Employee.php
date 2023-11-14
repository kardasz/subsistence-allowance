<?php

namespace App\Employee\Domain\Entity;

use App\Employee\Domain\Event\EmployeeCreated;
use App\Shared\Domain\AggregateRoot;
use App\Shared\Domain\ValueObject\EmployeeId;

class Employee extends AggregateRoot
{
    public EmployeeId $employeeId;

    public static function createNew(EmployeeId $employeeId): self
    {
        $user = new self();
        $user->recordThat(EmployeeCreated::withData($employeeId));

        return $user;
    }

    public function whenEmployeeCreated(EmployeeCreated $employeeCreated): void
    {
        $this->employeeId = $employeeCreated->employeeId;
    }
}
