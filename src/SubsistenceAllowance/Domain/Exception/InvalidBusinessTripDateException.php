<?php

namespace App\SubsistenceAllowance\Domain\Exception;

class InvalidBusinessTripDateException extends \Exception
{
    public function __construct(
        public readonly \DateTimeImmutable $start,
        public readonly \DateTimeImmutable $end,
        \Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'Provided dates from "%s" till "%s" are not valid',
                $this->start->format(\DateTime::ATOM),
                $this->end->format(\DateTime::ATOM)
            ),
            previous: $previous
        );
    }
}
