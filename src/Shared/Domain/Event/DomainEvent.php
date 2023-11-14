<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Symfony\Component\Uid\Uuid;

abstract class DomainEvent
{
    protected int $version = 0;
    protected string $aggregateId;
    protected string $eventId;
    protected \DateTimeImmutable $occurredOn;

    final public function __construct(
        string $aggregateId,
        string $eventId = null,
        \DateTimeImmutable $occurredOn = null,
    ) {
        $this->aggregateId = $aggregateId;

        if (null === $eventId) {
            $eventId = (string) Uuid::v4();
        }
        $this->eventId = $eventId;

        if (null === $occurredOn) {
            $occurredOn = new \DateTimeImmutable();
        }
        $this->occurredOn = $occurredOn;
    }

    public function withVersion(int $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getEventId(): ?string
    {
        return $this->eventId;
    }

    public function getOccurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    abstract public function getEventData(): array;
}
