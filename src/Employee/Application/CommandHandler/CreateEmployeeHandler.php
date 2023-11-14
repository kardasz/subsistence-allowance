<?php

namespace App\Employee\Application\CommandHandler;

use App\Employee\Application\Command\CreateEmployee;
use App\Employee\Domain\Entity\Employee;
use App\Employee\Domain\Repository\EmployeeRepositoryInterface;
use App\Shared\Domain\Command\CommandHandlerInterface;
use App\Shared\Domain\ValueObject\EmployeeId;

class CreateEmployeeHandler implements CommandHandlerInterface
{
    public function __construct(
        private EmployeeRepositoryInterface $userRepository
    ) {
    }

    public function __invoke(CreateEmployee $command)
    {
        $user = Employee::createNew(EmployeeId::generate());
        $this->userRepository->persist($user);

        return $user;
    }
}
