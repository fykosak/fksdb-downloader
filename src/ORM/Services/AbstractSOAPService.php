<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use Exception;
use Fykosak\NetteFKSDBDownloader\NetteFKSDBDownloader;
use Nette\SmartObject;

abstract class AbstractSOAPService {
    use SmartObject;

    protected NetteFKSDBDownloader $downloader;

    /**
     * ServiceEvent constructor.
     * @param NetteFKSDBDownloader $downloader
     * @throws Exception
     */
    public function __construct(NetteFKSDBDownloader $downloader) {
        $this->downloader = $downloader;
    }
}
