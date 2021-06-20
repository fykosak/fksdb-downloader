<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventListRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;

final class ServiceEventList extends AbstractSOAPService {

    /**
     * @param mixed ...$args
     * @return ModelEvent[]
     * @throws \Throwable
     * @deprecated
     */
    public function getAll(...$args): array {
        $items = parent::getItems(...$args);
        usort($items, function (ModelEvent $a, ModelEvent $b) {
            return $a->begin <=> $b->begin;
        });
        return $items;
    }

    /**
     * @param array $eventTypeIds
     * @return ModelEvent[]
     * @throws \Throwable
     */
    public function getEvents(array $eventTypeIds): array {
        $items = parent::getItems(new EventListRequest($eventTypeIds), 'event', ModelEvent::class);
        usort($items, function (ModelEvent $a, ModelEvent $b) {
            return $a->begin <=> $b->begin;
        });
        return $items;
    }

    /**
     * @param array $eventIds
     * @param int $year
     * @return ModelEvent[]
     * @throws \Throwable
     */
    public function getEventsByYear(array $eventIds, int $year): array {
        return array_filter($this->getEvents($eventIds), fn(ModelEvent $event) => $year == $event->begin->format('Y'));
    }

    /**
     * @param array $eventIds
     * @return ModelEvent
     * @throws \Throwable
     */
    public function getNewest(array $eventIds): ModelEvent {
        $events = $this->getEvents($eventIds);
        return end($events);
    }
}
