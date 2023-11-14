<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\Factory;

use App\Employee\Domain\Entity\Employee;
use App\Employee\Infrastructure\Repository\EmployeeRepository;
use App\Shared\Domain\ValueObject\EmployeeId;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Employee>
 *
 * @method        Employee|Proxy                     create(array|callable $attributes = [])
 * @method static Employee|Proxy                     createOne(array $attributes = [])
 * @method static Employee|Proxy                     find(object|array|mixed $criteria)
 * @method static Employee|Proxy                     findOrCreate(array $attributes)
 * @method static Employee|Proxy                     first(string $sortedField = 'id')
 * @method static Employee|Proxy                     last(string $sortedField = 'id')
 * @method static Employee|Proxy                     random(array $attributes = [])
 * @method static Employee|Proxy                     randomOrCreate(array $attributes = []))
 * @method static EmployeeRepository|RepositoryProxy repository()
 * @method static Employee[]|Proxy[]                 all()
 * @method static Employee[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Employee[]&Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Employee[]|Proxy[]                 findBy(array $attributes)
 * @method static Employee[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = []))
 * @method static Employee[]|Proxy[]                 randomSet(int $number, array $attributes = []))
 */
final class EmployeeFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return ['employeeId' => EmployeeId::generate()];
    }

    protected static function getClass(): string
    {
        return Employee::class;
    }
}
