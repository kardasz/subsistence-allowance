<?php

namespace App\Employee\Infrastructure\Controller;

use App\Employee\Application\Command\CreateEmployee;
use App\Employee\Domain\Entity\Employee;
use App\Shared\Domain\Command\CommandBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/employee', name: 'api_employee_create', methods: ['POST'])]
class CreateEmployeeController
{
    public function __construct(private CommandBusInterface $bus)
    {
    }

    public function __invoke(): Response
    {
        /** @var Employee $employee */
        $employee = $this->bus->dispatch(new CreateEmployee());

        return new JsonResponse(['id' => $employee->employeeId], Response::HTTP_CREATED);
    }
}
