<?php

namespace App\SubsistenceAllowance\Application\CommandHandler;

use App\Employee\Application\Query\FindEmployee;
use App\Employee\Domain\Entity\Employee;
use App\Shared\Domain\Command\CommandHandlerInterface;
use App\Shared\Domain\Query\QueryBusInterface;
use App\Shared\Domain\ValueObject\BusinessTripId;
use App\SubsistenceAllowance\Application\Command\CreateBusinessTrip;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use App\SubsistenceAllowance\Domain\Exception\BusinessTripAlreadyExistsException;
use App\SubsistenceAllowance\Domain\Exception\InvalidBusinessTripDateException;
use App\SubsistenceAllowance\Domain\Policy\BusinessTrip\AmountCalculatorInterface;
use App\SubsistenceAllowance\Domain\Repository\BusinessTripRepositoryInterface;

readonly class CreateBusinessTripHandler implements CommandHandlerInterface
{
    public function __construct(
        private BusinessTripRepositoryInterface $businessTripRepository,
        private AmountCalculatorInterface $amountCalculator,
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(CreateBusinessTrip $command): BusinessTrip
    {
        if ($command->start >= $command->end) {
            throw new InvalidBusinessTripDateException($command->start, $command->end);
        }

        if ($this->businessTripRepository->isExistsForUserBetweenStartAndEnd($command->employeeId, $command->start, $command->end)) {
            throw new BusinessTripAlreadyExistsException($command->employeeId, $command->start, $command->end);
        }

        /** @var Employee $employee */
        $employee = $this->queryBus->dispatch(new FindEmployee($command->employeeId));

        $amountDue = $this->amountCalculator->calculate(
            country: $command->country,
            start: $command->start,
            end: $command->end
        );

        $businessTrip = BusinessTrip::createNew(
            businessTripId: BusinessTripId::generate(),
            employeeId: $employee->employeeId,
            country: $command->country,
            amountDue: $amountDue,
            start: $command->start,
            end: $command->end
        );
        $this->businessTripRepository->persist($businessTrip);

        return $businessTrip;
    }
}
