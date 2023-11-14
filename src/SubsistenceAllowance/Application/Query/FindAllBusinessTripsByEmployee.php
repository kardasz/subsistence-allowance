<?php

namespace App\SubsistenceAllowance\Application\Query;

use App\Shared\Domain\Query\QueryInterface;
use App\Shared\Domain\ValueObject\EmployeeId;

readonly class FindAllBusinessTripsByEmployee implements QueryInterface
{
    public function __construct(public EmployeeId $employeeId)
    {
    }
}
