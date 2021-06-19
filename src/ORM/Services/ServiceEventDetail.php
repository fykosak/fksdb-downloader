<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;

final class ServiceEventDetail extends AbstractSOAPService {

    /**
     * @param int $eventId
     * @return ModelTeam[]
     * @throws \Exception
     * @throws \Throwable
     * @deprecated
     */
    public function getTeams(int $eventId): array {
        return $this->getAll($eventId);
    }

    protected function getParams(...$args): array {
        return [new EventRequest(...$args), 'team', ModelTeam::class];
    }
}
