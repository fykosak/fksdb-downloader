<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelParticipant;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;

final class ServiceEventDetail extends AbstractSOAPService
{

    protected function getRequest(int $eventId): Request
    {
        return new EventRequest($eventId);
    }

    /**
     * @param int $eventId
     * @param string|null $explicitExpiration
     * @return ModelTeam[]
     * @throws \Throwable
     */
    public function getTeams(int $eventId, ?string $explicitExpiration = null): array
    {
        return $this->getItems($this->getRequest($eventId), 'team', ModelTeam::class, $explicitExpiration);
    }

    /**
     * @param int $eventId
     * @param string|null $explicitExpiration
     * @return ModelParticipant[]
     * @throws \Throwable
     */
    public function getParticipants(int $eventId, ?string $explicitExpiration = null): array
    {
        return $this->getItems($this->getRequest($eventId), 'participants', ModelParticipant::class, $explicitExpiration);
    }
}
