<?php

namespace Fykosak\FKSDBDownloader\Downloader;

use Exception;
use Nette\SmartObject;

abstract class AbstractSOAPService {
    use SmartObject;

    protected Downloader $downloader;

    /**
     * ServiceEvent constructor.
     * @param Downloader $downloader
     * @throws Exception
     */
    public function __construct(Downloader $downloader) {
        $this->downloader = $downloader;
    }
}
