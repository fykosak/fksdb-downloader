<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventListRequest;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;
use Throwable;

final class ServiceEventList extends AbstractSOAPService {

    /** @var ModelEvent[] */
    private array $events;

    /**
     * @param array $eventIds
     * @throws Throwable
     */
    private function loadEvents(array $eventIds): void {
        $this->events = $this->load(new EventListRequest($eventIds), 'event', 'event-list', ModelEvent::class);
    }

    protected function load(Request $request, string $rootNodeName, string $cacheKey, string $modelClassName): array {
        $items = parent::load($request, $rootNodeName, $cacheKey, $modelClassName);
        usort($items, function (ModelEvent $a, ModelEvent $b) {
            return $a->begin <=> $b->begin;
        });
        return $items;
    }

    /**
     * @param array $eventIds
     * @param int $year
     * @return ModelEvent[]
     * @throws Throwable
     */
    public function getEventsByYear(array $eventIds, int $year): array {
        $this->loadEvents($eventIds);
        return array_filter($this->events, fn(ModelEvent $event) => $year == $event->begin->format('Y'));
    }

    /**
     * @param array $eventIds
     * @return ModelEvent
     * @throws Throwable
     */
    public function getNewest(array $eventIds): ModelEvent {
        $this->loadEvents($eventIds);
        return end($this->events);
    }
}
