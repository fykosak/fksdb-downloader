<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelParticipant;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;

final class ServiceEventDetail extends AbstractSOAPService {

    protected function getRequest(int $eventId): Request {
        return new EventRequest($eventId);
    }

    /**
     * @param mixed ...$args
     * @return array
     * @throws \Throwable
     * @deprecated
     */
    public function getAll(...$args): array {
        return $this->getTeams(...$args);
    }

    /**
     * @param int $eventId
     * @return ModelTeam[]
     * @throws \Throwable
     */
    public function getTeams(int $eventId): array {
        return $this->getItems($this->getRequest($eventId), 'team', ModelTeam::class);
    }

    /**
     * @param int $eventId
     * @return ModelParticipant[]
     * @throws \Throwable
     */
    public function getParticipants(int $eventId): array {
        return $this->getItems($this->getRequest($eventId), 'participants', ModelParticipant::class);
    }
}
