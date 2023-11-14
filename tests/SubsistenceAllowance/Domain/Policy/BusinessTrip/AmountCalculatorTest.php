<?php

namespace App\Tests\SubsistenceAllowance\Domain\Policy\BusinessTrip;

use App\SubsistenceAllowance\Domain\Policy\BusinessTrip\AmountCalculator;
use App\SubsistenceAllowance\Domain\ValueObject\Country;
use PHPUnit\Framework\TestCase;

class AmountCalculatorTest extends TestCase
{
    /**
     * @dataProvider calculatorProvider
     */
    public function testAmount(int $expected, Country $country, \DateTimeImmutable $start, \DateTimeImmutable $end): void
    {
        $subject = new AmountCalculator();
        $actual = $subject->calculate($country, $start, $end);

        $this->assertEquals($expected, $actual);
    }

    public static function calculatorProvider(): iterable
    {
        // less than 8 hours
        yield [0, Country::PL, new \DateTimeImmutable('2023-11-14 08:00:00'), new \DateTimeImmutable('2023-11-14 15:30:00')];

        // 8 hours at saturday
        yield [0, Country::PL, new \DateTimeImmutable('2023-11-18 08:00:00'), new \DateTimeImmutable('2023-11-18 16:00:00')];

        // 8 hours
        yield [10, Country::PL, new \DateTimeImmutable('2023-11-14 08:00:00'), new \DateTimeImmutable('2023-11-14 16:00:00')];

        // weekend only
        yield [0, Country::PL, new \DateTimeImmutable('2023-11-25 08:00:00'), new \DateTimeImmutable('2023-11-26 23:59:59')];

        // from saturday till wednesday
        yield [30, Country::PL, new \DateTimeImmutable('2023-11-18 00:00:00'), new \DateTimeImmutable('2023-11-22 23:59:59')];

        // 1 week
        yield [50, Country::PL, new \DateTimeImmutable('2023-11-13 00:00:00'), new \DateTimeImmutable('2023-11-19 23:59:59')];

        // 3 weeks
        yield [250, Country::PL, new \DateTimeImmutable('2023-11-13 00:00:00'), new \DateTimeImmutable('2023-12-03 23:59:59')];
    }
}
