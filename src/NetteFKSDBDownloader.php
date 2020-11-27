<?php

namespace Fykosak\NetteFKSDBDownloader;

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Request\IRequest;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\SmartObject;
use SoapFault;

class NetteFKSDBDownloader {
    use SmartObject;

    private FKSDBDownloader $downloader;
    private Cache $cache;

    /**
     * Downloader constructor.
     * @param string $wsdl
     * @param string $username
     * @param string $password
     * @param IStorage $storage
     * @throws SoapFault
     */
    public function __construct(string $wsdl, string $username, string $password, IStorage $storage) {
        $this->cache = new Cache($storage, self::class);
        $this->downloader = new FKSDBDownloader($wsdl, $username, $password);
    }

    public function download(IRequest $request): string {
        return $this->cache->load($request->getCacheKey(), function (&$dependencies) use ($request) {
            $dependencies[Cache::EXPIRE] = '20 minutes';
            return $this->downloader->download($request);
        });
    }
}
