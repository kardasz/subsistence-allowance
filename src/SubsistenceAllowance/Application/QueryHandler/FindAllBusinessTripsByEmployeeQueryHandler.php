<?php

namespace App\SubsistenceAllowance\Application\QueryHandler;

use App\Employee\Domain\Exception\EmployeeNotFoundException;
use App\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Shared\Domain\Query\QueryHandlerInterface;
use App\SubsistenceAllowance\Application\Query\FindAllBusinessTripsByEmployee;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use App\SubsistenceAllowance\Domain\Repository\BusinessTripRepositoryInterface;

readonly class FindAllBusinessTripsByEmployeeQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
        private BusinessTripRepositoryInterface $businessTripRepository
    ) {
    }

    /**
     * @return BusinessTrip[]
     */
    public function __invoke(FindAllBusinessTripsByEmployee $query): array
    {
        if (null === $this->employeeRepository->findById($query->employeeId)) {
            throw new EmployeeNotFoundException($query->employeeId);
        }

        return $this->businessTripRepository->findByEmployee($query->employeeId);
    }
}
