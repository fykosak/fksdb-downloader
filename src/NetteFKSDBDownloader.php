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

    /**
     * Downloader constructor.
     * @param string $wsdl
     * @param string $username
     * @param string $password
     * @param Storage $storage
     * @throws SoapFault
     */
    public function __construct(string $wsdl, string $username, string $password, Storage $storage) {
        $this->cache = new Cache($storage, self::class);
        $this->downloader = new FKSDBDownloader($wsdl, $username, $password);
    }

    /**
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function download(Request $request): string {
        return $this->cache->load($request->getCacheKey(), function (&$dependencies) use ($request): string {
            $dependencies[Cache::EXPIRE] = '60 minutes';
            return $this->downloader->download($request);
        });
    }
}
