<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use DOMDocument;
use Exception;
use Fykosak\FKSDBDownloaderCore\Requests\EventListRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;

class ServiceEvent extends AbstractSOAPService {
    /** @var ModelEvent[] */
    private array $events;

    /**
     * @throws Exception
     */
    private function loadEvents(): void {
        if (!isset($this->events)) {
            $xml = $this->downloader->download(new EventListRequest([9]));
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
     * @param int $year
     * @return ModelEvent|null
     * @throws Exception
     */
    public function getEventByYear(int $year): ?ModelEvent {
        $this->loadEvents();
        foreach ($this->events as $event) {
            if ($event->eventYear === $year) {
                return $event;
            }
        }
        return null;
    }

    /**
     * @return ModelEvent
     * @throws Exception
     */
    public function getNewest(): ModelEvent {
        $this->loadEvents();
        return end($this->events);
    }
}
