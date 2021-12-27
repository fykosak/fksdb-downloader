<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader;

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\SmartObject;
use SoapFault;

final class NetteFKSDBDownloader
{
    use SmartObject;

    private FKSDBDownloader $downloader;
    private array $params;
    private Cache $cache;
    private string $expiration;

    /**
     * Downloader constructor.
     * @param string $wsdl
     * @param string $username
     * @param string $password
     * @param string $expiration
     * @param Storage $storage
     */
    public function __construct(string $wsdl, string $username, string $password, string $expiration, Storage $storage)
    {
        $this->cache = new Cache($storage, self::class);
        $this->params = [$wsdl, $username, $password];
        $this->expiration = $expiration;
    }

    public function getDownloader(): FKSDBDownloader
    {
        if (!isset($this->downloader)) {
            $this->downloader = new FKSDBDownloader(...$this->params);
        }
        return $this->downloader;
    }

    /**
     * @throws \Throwable
     */
    public function download(Request $request, ?string $explicitExpiration = null): string
    {
        return $this->cache->load(
            $request->getCacheKey() . '-xml',
            function (&$dependencies) use ($request, $explicitExpiration): string {
                $dependencies[Cache::EXPIRE] = $explicitExpiration ?? $this->expiration;
                return $this->getDownloader()->download($request);
            }
        );
    }

    /**
     * @throws \Throwable
     */
    public function downloadJSON(Request $request, ?string $explicitExpiration = null): string
    {
        return $this->cache->load(
            $request->getCacheKey() . '-json',
            function (&$dependencies) use ($request, $explicitExpiration): string {
                $dependencies[Cache::EXPIRE] = $explicitExpiration ?? $this->expiration;
                return $this->getDownloader()->downloadJSON($request);
            }
        );
    }
}
