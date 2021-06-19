<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;
use Fykosak\NetteFKSDBDownloader\ORM\Models\ModelTeam;

final class ServiceEventDetail extends AbstractSOAPService {

    protected function getParams(...$args): array {
        return [new EventRequest(...$args), 'team', ModelTeam::class];
    }
}
