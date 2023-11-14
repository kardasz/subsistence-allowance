<?php

namespace App\Shared\Infrastructure\Doctrine\DBAL\Types;

use App\Shared\Domain\ValueObject\EmployeeId;
use Symfony\Bridge\Doctrine\Types\AbstractUidType;

class EmployeeIdType extends AbstractUidType
{
    public const NAME = 'employee_id';

    public function getName(): string
    {
        return self::NAME;
    }

    protected function getUidClass(): string
    {
        return EmployeeId::class;
    }
}
