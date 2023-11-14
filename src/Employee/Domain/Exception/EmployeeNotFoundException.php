<?php

namespace App\Employee\Domain\Exception;

use App\Shared\Domain\ValueObject\EmployeeId;

class EmployeeNotFoundException extends \Exception
{
    public function __construct(
        public readonly EmployeeId $employeeId,
        \Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'Employee "%s" not found',
                $this->employeeId
            ),
            previous: $previous
        );
    }
}
