<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\DomainEvent;

trait EventHandlerTrait
{
    protected function apply(DomainEvent $event): void
    {
        $handler = $this->determineEventHandlerMethodFor($event);

        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf('Missing event handler method %s for aggregate root %s', $handler, static::class));
        }

        $this->{$handler}($event);
    }

    protected function determineEventHandlerMethodFor(DomainEvent $e): string
    {
        return 'when'.implode('', \array_slice(explode('\\', $e::class), -1));
    }
}
