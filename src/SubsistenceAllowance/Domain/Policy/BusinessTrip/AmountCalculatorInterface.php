<?php

namespace App\SubsistenceAllowance\Domain\Policy\BusinessTrip;

use App\SubsistenceAllowance\Domain\ValueObject\Country;

interface AmountCalculatorInterface
{
    public function calculate(Country $country, \DateTimeImmutable $start, \DateTimeImmutable $end): int;
}
