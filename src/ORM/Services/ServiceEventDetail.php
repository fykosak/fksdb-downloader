<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Exception;
use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;
use Throwable;

final class ServiceEventDetail extends AbstractSOAPService {

    /**
     * @param int $eventId
     * @return ModelTeam[]
     * @throws Exception
     * @throws Throwable
     */
    public function getTeams(int $eventId): array {
        return $this->load(new EventRequest($eventId), 'team', sprintf('teams.%s', $eventId), ModelTeam::class);
    }
}
