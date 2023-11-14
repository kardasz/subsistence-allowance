<?php

namespace App\Tests\SubsistenceAllowance\Infrastructure\Controller;

use App\Employee\Domain\Entity\Employee;
use App\Employee\Infrastructure\Factory\EmployeeFactory;
use App\Shared\Domain\ValueObject\BusinessTripId;
use App\SubsistenceAllowance\Domain\Entity\BusinessTrip;
use App\SubsistenceAllowance\Domain\ValueObject\Country;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class ListBusinessTripsControllerTest extends WebTestCase
{
    use PHPMatcherAssertions;

    public function testListBusinessTrips(): void
    {
        $client = $this->createClient();

        /** @var Employee $employee */
        $employee = EmployeeFactory::createOne();
        $employeeId = $employee->employeeId;

        $em = static::getContainer()->get(EntityManagerInterface::class);

        $em->persist(
            BusinessTrip::createNew(
                BusinessTripId::generate(),
                $employeeId,
                Country::PL,
                50,
                new \DateTimeImmutable('2023-11-13 00:00:00'),
                new \DateTimeImmutable('2023-11-17 23:59:59')
            )
        );

        $em->persist(
            BusinessTrip::createNew(
                BusinessTripId::generate(),
                $employeeId,
                Country::PL,
                50,
                new \DateTimeImmutable('2023-12-06 00:00:00'),
                new \DateTimeImmutable('2023-12-12 23:59:59')
            )
        );

        $em->flush();

        $client->request(method: 'GET', uri: '/api/business-trip/'.$employeeId);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertMatchesPattern(
            <<<'JSON'
            [
               {
                  "start":"2023-11-13 00:00:00",
                  "end":"2023-11-17 23:59:59",
                  "country":"PL",
                  "amount_due":50
               },
               {
                  "start":"2023-12-06 00:00:00",
                  "end":"2023-12-12 23:59:59",
                  "country":"PL",
                  "amount_due":50
               }
            ]
            JSON,
            $client->getResponse()->getContent()
        );
    }
}
