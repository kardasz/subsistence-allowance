<?php

namespace App\Tests\SubsistenceAllowance\Application\CommandHandler;

use App\Employee\Domain\Entity\Employee;
use App\Employee\Infrastructure\Factory\EmployeeFactory;
use App\SubsistenceAllowance\Application\Command\CreateBusinessTrip;
use App\SubsistenceAllowance\Application\CommandHandler\CreateBusinessTripHandler;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use App\SubsistenceAllowance\Domain\Exception\BusinessTripAlreadyExistsException;
use App\SubsistenceAllowance\Domain\Exception\InvalidBusinessTripDateException;
use App\SubsistenceAllowance\Domain\ValueObject\Country;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateBusinessTripHandlerTest extends KernelTestCase
{
    public function testCreateCreateBusinessTrip(): void
    {
        self::bootKernel();

        /** @var Employee $employee */
        $employee = EmployeeFactory::createOne();

        $command = new CreateBusinessTrip(
            employeeId: $employee->employeeId,
            country: Country::PL,
            start: new \DateTimeImmutable('2023-11-14 08:00:00'),
            end: new \DateTimeImmutable('2023-11-14 20:00:00')
        );

        $handler = static::getContainer()->get(CreateBusinessTripHandler::class);
        $response = $handler($command);

        $this->assertInstanceOf(BusinessTrip::class, $response);
        $this->assertEquals(10, $response->amountDue);
    }

    public function testThrownBusinessTripAlreadyExistsException(): void
    {
        self::bootKernel();

        /** @var Employee $employee */
        $employee = EmployeeFactory::createOne();

        $command = new CreateBusinessTrip(
            employeeId: $employee->employeeId,
            country: Country::PL,
            start: new \DateTimeImmutable('2023-10-05 00:00:00'),
            end: new \DateTimeImmutable('2023-10-18 23:59:59'),
        );

        $handler = static::getContainer()->get(CreateBusinessTripHandler::class);
        $handler($command);

        $command = new CreateBusinessTrip(
            employeeId: $employee->employeeId,
            country: Country::PL,
            start: new \DateTimeImmutable('2023-10-01 00:00:00'),
            end: new \DateTimeImmutable('2023-10-08 23:59:59'),
        );

        $this->expectExceptionObject(
            new BusinessTripAlreadyExistsException(
                $employee->employeeId,
                new \DateTimeImmutable('2023-10-01 00:00:00'),
                new \DateTimeImmutable('2023-10-08 23:59:59')
            )
        );

        $handler = static::getContainer()->get(CreateBusinessTripHandler::class);
        $handler($command);
    }

    public function testThrownInvalidBusinessTripDateException(): void
    {
        self::bootKernel();

        /** @var Employee $employee */
        $employee = EmployeeFactory::createOne();

        $command = new CreateBusinessTrip(
            employeeId: $employee->employeeId,
            country: Country::PL,
            start: new \DateTimeImmutable('2023-11-11 08:00:00'),
            end: new \DateTimeImmutable('2023-11-11 07:00:00')
        );

        $this->expectExceptionObject(
            new InvalidBusinessTripDateException(
                new \DateTimeImmutable('2023-11-11 08:00:00'),
                new \DateTimeImmutable('2023-11-11 07:00:00')
            )
        );

        $handler = static::getContainer()->get(CreateBusinessTripHandler::class);
        $handler($command);
    }
}
