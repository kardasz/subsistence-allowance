<?php

namespace App\Employee\Application\QueryHandler;

use App\Employee\Application\Query\FindEmployee;
use App\Employee\Domain\Entity\Employee;
use App\Employee\Domain\Exception\EmployeeNotFoundException;
use App\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Shared\Domain\Query\QueryHandlerInterface;

readonly class FindEmployeeQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository
    ) {
    }

    public function __invoke(FindEmployee $query): Employee
    {
        $result = $this->employeeRepository->findById($query->employeeId);
        if (null === $result) {
            throw new EmployeeNotFoundException($query->employeeId);
        }

        return $result;
    }
}
