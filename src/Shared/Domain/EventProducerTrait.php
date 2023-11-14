<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\DomainEvent;

trait EventProducerTrait
{
    protected int $version = 0;

    /**
     * @var array<DomainEvent>
     */
    protected array $recordedEvents = [];

    protected function recordThat(DomainEvent $event): void
    {
        ++$this->version;
        $this->recordedEvents[] = $event->withVersion($this->version);

        $this->apply($event);
    }

    abstract protected function apply(DomainEvent $event): void;

    /**
     * @return DomainEvent[]
     */
    public function popEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];

        return $events;
    }
}
