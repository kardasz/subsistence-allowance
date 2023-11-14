<?php

namespace App\SubsistenceAllowance\Infrastructure\Controller;

use App\Shared\Domain\Query\QueryBusInterface;
use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Application\Query\FindAllBusinessTripsByEmployee;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route('/api/business-trip/{employeeId}', name: 'api_business_trip_list', methods: ['GET'])]
readonly class ListBusinessTripsController
{
    public function __construct(
        private QueryBusInterface $queryBus
    ) {
    }

    public function __invoke(Request $request, string $employeeId): Response
    {
        try {
            /** @var BusinessTrip $businessTrip */
            $results = $this->queryBus->dispatch(new FindAllBusinessTripsByEmployee(EmployeeId::fromString($employeeId)));

            return new JsonResponse(
                array_map(
                    static fn (BusinessTrip $businessTrip) => [
                        'start' => $businessTrip->start->format('Y-m-d H:i:s'),
                        'end' => $businessTrip->end->format('Y-m-d H:i:s'),
                        'country' => $businessTrip->country->value,
                        'amount_due' => $businessTrip->amountDue,
                    ],
                    $results
                )
            );
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
