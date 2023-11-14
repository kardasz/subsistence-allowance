<?php

namespace App\Tests\Employee\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateEmployeeControllerTest extends WebTestCase
{
    public function testUserCreate(): void
    {
        $client = $this->createClient();
        $client->request('POST', '/api/employee');
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $this->assertArrayHasKey('id', \json_decode($response->getContent(), true));
    }
}
