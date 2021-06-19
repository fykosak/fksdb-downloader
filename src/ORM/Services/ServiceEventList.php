<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventListRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;

final class ServiceEventList extends AbstractSOAPService {

    /** @var ModelEvent[] */
    private array $events;

    public function getAll(...$args): array {
        $items = parent::getAll(...$args);
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
        return array_filter($this->getAll($eventIds), fn(ModelEvent $event) => $year == $event->begin->format('Y'));
    }

    /**
     * @param array $eventIds
     * @return ModelEvent
     * @throws \Throwable
     */
    public function getNewest(array $eventIds): ModelEvent {
        $events = $this->getAll($eventIds);
        return end($events);
    }

    protected function getParams(...$args): array {
        return [new EventListRequest(...$args), 'event', ModelEvent::class];
    }
}
