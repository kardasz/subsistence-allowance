<?php

namespace App\SubsistenceAllowance\Domain\Policy\BusinessTrip;

use App\SubsistenceAllowance\Domain\ValueObject\Country;
use App\SubsistenceAllowance\Domain\ValueObject\Rate;

class AmountCalculator implements AmountCalculatorInterface
{
    public function calculate(Country $country, \DateTimeImmutable $start, \DateTimeImmutable $end): int
    {
        $diff = $end->diff($start);
        if (!$this->minPeriod($diff)) {
            return 0;
        }

        $rate = Rate::byCountry($country);
        $amount = !$this->isWeekend($start) ? $rate->value : 0;
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end, \DatePeriod::EXCLUDE_START_DATE);

        foreach ($period as $current) {
            if ($this->isWeekend($current)) {
                continue;
            }

            $amount += $this->isGreatherThan7Days($current->diff($start)) ? $rate->value * 2 : $rate->value;
        }

        return $amount;
    }

    private function isGreatherThan7Days(\DateInterval $interval): bool
    {
        return $interval->y > 0 || $interval->m > 0 || $interval->d >= 7;
    }

    private function minPeriod(\DateInterval $interval): bool
    {
        return $interval->y > 0 || $interval->m > 0 || $interval->d > 0 || $interval->h >= 8;
    }

    private function isWeekend(\DateTimeInterface $date): bool
    {
        return $date->format('N') >= 6;
    }
}
