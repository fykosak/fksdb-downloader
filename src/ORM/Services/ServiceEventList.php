<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use DOMDocument;
use Fykosak\FKSDBDownloaderCore\Requests\EventListRequest;
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
        if (!isset($this->events)) {
            $xml = $this->downloader->download(new EventListRequest($eventIds));
            $doc = new DOMDocument();
            $doc->loadXML($xml);
            foreach ($doc->getElementsByTagName('event') as $eventNode) {
                $event = ModelEvent::createFromXMLNode($eventNode);
                $this->events[] = $event;
            }
            usort($this->events, function (ModelEvent $a, ModelEvent $b) {
                return $a->begin <=> $b->begin;
            });
        }
    }


    /**
     * @param array $eventIds
     * @param int $year
     * @return ModelEvent|null
     * @throws Throwable
     */
    public function getEventByYear(array $eventIds, int $year): ?ModelEvent {
        $this->loadEvents($eventIds);
        foreach ($this->events as $event) {
            if ($event->eventYear === $year) {
                return $event;
            }
        }
        return null;
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
