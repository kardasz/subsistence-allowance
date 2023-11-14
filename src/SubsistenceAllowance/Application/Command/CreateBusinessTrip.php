<?php

namespace App\SubsistenceAllowance\Application\Command;

use App\Shared\Domain\Command\CommandInterface;
use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Domain\ValueObject\Country;

readonly class CreateBusinessTrip implements CommandInterface
{
    public function __construct(
        public EmployeeId $employeeId,
        public Country $country,
        public \DateTimeImmutable $start,
        public \DateTimeImmutable $end,
    ) {
    }
}
