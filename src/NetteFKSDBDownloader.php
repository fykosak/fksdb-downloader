<?php

namespace Fykosak\NetteFKSDBDownloader;

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\SmartObject;
use SoapFault;
use Throwable;

final class NetteFKSDBDownloader {

    use SmartObject;

    private FKSDBDownloader $downloader;
    private Cache $cache;
    private string $expiration;

    /**
     * Downloader constructor.
     * @param string $wsdl
     * @param string $username
     * @param string $password
     * @param string $expiration
     * @param Storage $storage
     * @throws SoapFault
     */
    public function __construct(string $wsdl, string $username, string $password, string $expiration, Storage $storage) {
        $this->cache = new Cache($storage, self::class);
        $this->downloader = new FKSDBDownloader($wsdl, $username, $password);
        $this->expiration = $expiration;
    }

    /**
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function download(Request $request): string {
        return $this->cache->load($request->getCacheKey(), function (&$dependencies) use ($request): string {
            $dependencies[Cache::EXPIRE] = $this->expiration;
            return $this->downloader->download($request);
        });
    }
}
