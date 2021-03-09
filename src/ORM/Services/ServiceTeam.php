<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use DOMDocument;
use Exception;
use Fykosak\FKSDBDownloaderCore\Requests\Event\TeamsListRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;
use Throwable;

final class ServiceTeam extends AbstractSOAPService {

    private array $teams = [];

    /**
     * @param int $eventId
     * @return ModelTeam[]
     * @throws Exception
     * @throws Throwable
     */
    public function getTeams(int $eventId): array {
        if (!isset($this->teams[$eventId])) {
            $this->teams[$eventId] = [];
            $xml = $this->downloader->download(new TeamsListRequest($eventId));
            $doc = new DOMDocument();
            $doc->loadXML($xml);
            foreach ($doc->getElementsByTagName('team') as $teamNode) {
                $this->teams[$eventId][] = ModelTeam::createFromXMLNode($teamNode);
            }
        }
        return $this->teams[$eventId];
    }
}
