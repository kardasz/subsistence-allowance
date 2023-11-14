<?php

namespace App\SubsistenceAllowance\Infrastructure\Controller;

use App\Shared\Domain\Command\CommandBusInterface;
use App\Shared\Domain\ValueObject\EmployeeId;
use App\SubsistenceAllowance\Application\Command\CreateBusinessTrip;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use App\SubsistenceAllowance\Domain\ValueObject\Country;
use App\SubsistenceAllowance\Infrastructure\DTO\BusinessTripDto;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsController]
#[Route('/api/business-trip', name: 'api_business_trip_create', methods: ['POST'])]
class CreateBusinessTripController
{
    public function __construct(
        private readonly CommandBusInterface $bus,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function __invoke(Request $request): Response
    {
        /** @var BusinessTripDto $businessTripDto */
        $businessTripDto = $this->serializer->deserialize($request->getContent(), BusinessTripDto::class, 'json');

        $errors = $this->validator->validate($businessTripDto);

        if (count($errors) > 0) {
            return new JsonResponse(
                [
                    'errors' => array_map(
                        fn (ConstraintViolationInterface $e) => ['property' => $e->getPropertyPath(), 'message' => $e->getMessage()],
                        iterator_to_array($errors)
                    ),
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            /** @var BusinessTrip $businessTrip */
            $businessTrip = $this->bus->dispatch(
                new CreateBusinessTrip(
                    employeeId: EmployeeId::fromString($businessTripDto->employeeId),
                    country: Country::fromString($businessTripDto->country),
                    start: new \DateTimeImmutable($businessTripDto->start),
                    end: new \DateTimeImmutable($businessTripDto->end)
                )
            );

            return new JsonResponse(['id' => $businessTrip->businessTripId], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
