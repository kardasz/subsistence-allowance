<?php

namespace App\Employee\Domain\Repository;

use App\Employee\Domain\Entity\Employee;
use App\Shared\Domain\ValueObject\EmployeeId;

interface EmployeeRepositoryInterface
{
    public function findById(EmployeeId $id): ?Employee;

    public function persist(Employee $employee): void;
}
