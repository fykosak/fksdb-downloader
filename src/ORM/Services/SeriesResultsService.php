<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\FKSDBDownloaderCore\Requests\SeriesResultsRequest;

class SeriesResultsService extends AbstractJSONService
{
    protected function getRequest(int $contestId, int $year, int $series): Request
    {
        return new SeriesResultsRequest($contestId, $year, $series);
    }
}
