<?php

namespace App\SubsistenceAllowance\Domain\Repository;

use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;

interface BusinessTripRepositoryInterface
{
    /**
     * @return BusinessTrip[]
     */
    public function findByEmployee(EmployeeId $employeeId): array;

    public function isExistsForUserBetweenStartAndEnd(EmployeeId $employeeId, \DateTimeImmutable $start, \DateTimeImmutable $end): bool;

    public function persist(BusinessTrip $businessTrip): void;
}
