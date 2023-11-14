<?php

namespace App\SubsistenceAllowance\Infrastructure\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class BusinessTripDto
{
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[SerializedName('employee_id')]
    public string $employeeId;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['PL', 'DE', 'GB'])]
    public string $country;

    #[Assert\NotBlank]
    #[Assert\DateTime]
    public string $start;

    #[Assert\NotBlank]
    #[Assert\DateTime]
    public string $end;
}
