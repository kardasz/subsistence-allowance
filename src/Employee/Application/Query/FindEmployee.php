<?php

namespace App\Employee\Application\Query;

use App\Shared\Domain\Query\QueryInterface;
use App\Shared\Domain\ValueObject\EmployeeId;

readonly class FindEmployee implements QueryInterface
{
    public function __construct(public EmployeeId $employeeId)
    {
    }
}
