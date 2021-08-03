<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventListRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;

final class ServiceEventList extends AbstractSOAPService
{

    /**
     * @param array $eventTypeIds
     * @param string|null $explicitExpiration
     * @return ModelEvent[]
     * @throws \Throwable
     */
    public function getEvents(array $eventTypeIds, ?string $explicitExpiration = null): array
    {
        $items = parent::getItems(new EventListRequest($eventTypeIds), 'event', ModelEvent::class, $explicitExpiration);
        usort($items, fn(ModelEvent $a, ModelEvent $b): int => $a->begin <=> $b->begin);
        return $items;
    }

    /**
     * @param array $eventIds
     * @param int $year
     * @param string|null $explicitExpiration
     * @return ModelEvent[]
     * @throws \Throwable
     */
    public function getEventsByYear(array $eventIds, int $year, ?string $explicitExpiration = null): array
    {
        return array_filter(
            $this->getEvents($eventIds, $explicitExpiration),
            fn(ModelEvent $event): bool => $year == $event->begin->format('Y')
        );
    }

    /**
     * @param array $eventIds
     * @param string|null $explicitExpiration
     * @return ModelEvent
     * @throws \Throwable
     */
    public function getNewest(array $eventIds, ?string $explicitExpiration = null): ModelEvent
    {
        $events = $this->getEvents($eventIds, $explicitExpiration);
        return end($events);
    }
}
