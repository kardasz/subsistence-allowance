<?php

namespace App\SubsistenceAllowance\Domain\Exception;

use App\Shared\Domain\ValueObject\EmployeeId;

class BusinessTripAlreadyExistsException extends \Exception
{
    public function __construct(
        public readonly EmployeeId $employeeId,
        public readonly \DateTimeImmutable $start,
        public readonly \DateTimeImmutable $end,
        \Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'Business trip already exists between "%s" and "%s" for employee "%s"',
                $this->start->format(\DateTime::ATOM),
                $this->end->format(\DateTime::ATOM),
                $this->employeeId
            ),
            previous: $previous
        );
    }
}
