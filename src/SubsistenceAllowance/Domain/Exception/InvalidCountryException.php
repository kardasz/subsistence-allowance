<?php

namespace App\SubsistenceAllowance\Domain\Exception;

class InvalidCountryException extends \Exception
{
    public function __construct(
        public readonly string $country,
        \Throwable $previous = null
    ) {
        parent::__construct(
            sprintf(
                'Invalid country "%s"',
                $this->country
            ),
            previous: $previous
        );
    }
}
