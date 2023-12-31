<?php

declare(strict_types=1);

namespace App\Shared\Domain;

abstract class AggregateRoot
{
    use EventProducerTrait;
    use EventHandlerTrait;
}
