<?php

namespace App\Tests\SubsistenceAllowance\Infrastructure\Controller;

use App\Employee\Domain\Entity\Employee;
use App\Employee\Infrastructure\Factory\EmployeeFactory;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateBusinessTripControllerTest extends WebTestCase
{
    use PHPMatcherAssertions;

    public function testCreateBusinessTrip(): void
    {
        $client = $this->createClient();

        /** @var Employee $employee */
        $employee = EmployeeFactory::createOne();
        $employeeId = $employee->employeeId;

        $json = <<<JSON
            {
                "employee_id": "$employeeId",
                "country": "PL",
                "start": "2023-11-13 00:00:00",
                "end": "2023-11-17 23:59:59"
            }
            JSON;

        $client->request(method: 'POST', uri: '/api/business-trip', server: ['CONTENT_TYPE' => 'application/json'], content: $json);

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('id', \json_decode($response->getContent(), true));
    }

    public function testValidationErrors(): void
    {
        $client = $this->createClient();

        $client->request(method: 'POST', uri: '/api/business-trip', server: ['CONTENT_TYPE' => 'application/json'], content: '{}');

        $this->assertResponseStatusCodeSame(400);
        $this->assertMatchesPattern(
            <<<'JSON'
            {
               "errors":[
                  {
                     "property":"employeeId",
                     "message":"This value should not be blank."
                  },
                  {
                     "property":"country",
                     "message":"This value should not be blank."
                  },
                  {
                     "property":"start",
                     "message":"This value should not be blank."
                  },
                  {
                     "property":"end",
                     "message":"This value should not be blank."
                  }
               ]
            }
            JSON,
            $client->getResponse()->getContent()
        );
    }
}
