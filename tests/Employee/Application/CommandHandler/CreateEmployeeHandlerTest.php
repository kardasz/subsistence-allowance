<?php

namespace App\Tests\Employee\Application\CommandHandler;

use App\Employee\Application\Command\CreateEmployee;
use App\Employee\Application\CommandHandler\CreateEmployeeHandler;
use App\Employee\Domain\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateEmployeeHandlerTest extends KernelTestCase
{
    public function testCreateEmployee(): void
    {
        self::bootKernel();

        $command = new CreateEmployee();

        $handler = static::getContainer()->get(CreateEmployeeHandler::class);
        $response = $handler($command);

        $this->assertInstanceOf(Employee::class, $response);
    }
}
