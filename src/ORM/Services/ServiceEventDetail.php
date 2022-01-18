<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelEvent;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelParticipant;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelPersonSchedule;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelSchedule;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;

final class ServiceEventDetail extends AbstractJSONService
{
    protected function getRequest(int $eventId): Request
    {
        return new EventRequest($eventId);
    }

    public function getEvent(int $eventId, ?string $explicitExpiration = null): ModelEvent {
        return $this->getItem(
            $this->getRequest($eventId),
            [],
            ModelEvent::class,
            false,
            $explicitExpiration);
    }

    /**
     * @return ModelTeam[]
     */
    public function getTeams(int $eventId, ?string $explicitExpiration = null): array {
        return $this->getItem(
            $this->getRequest($eventId),
            ["teams"],
            ModelTeam::class,
            true,
            $explicitExpiration);
    }

    /**
     * @return ModelSchedule[]
     */
    public function getSchedule(int $eventId, ?string $explicitExpiration = null): array {
        return $this->getItem(
            $this->getRequest($eventId),
            ["schedule"],
            ModelSchedule::class,
            true,
            $explicitExpiration);
    }

    /**
     * @return ModelParticipant[]
     */
    public function getParticipants(int $eventId, ?string $explicitExpiration = null): array {
        return $this->getItem(
            $this->getRequest($eventId),
            ["participants"],
            ModelParticipant::class,
            true,
            $explicitExpiration);
    }

    /**
     * @return ModelPersonSchedule[]
     */
    public function getPersonSchedule(int $eventId, ?string $explicitExpiration = null): array {
        return $this->getItem(
            $this->getRequest($eventId),
            ["person_schedule"],
            ModelPersonSchedule::class,
            true,
            $explicitExpiration);
    }
}
