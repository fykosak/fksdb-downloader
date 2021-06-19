<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use DOMDocument;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\NetteFKSDBDownloader\NetteFKSDBDownloader;
use Fykosak\NetteFKSDBDownloader\ORM\Models\AbstractSOAPModel;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\SmartObject;
use Throwable;

abstract class AbstractSOAPService {

    use SmartObject;

    protected NetteFKSDBDownloader $downloader;
    /**
     * @var AbstractSOAPModel[]
     */
    protected array $items;

    protected Cache $cache;

    /**
     * ServiceEvent constructor.
     * @param NetteFKSDBDownloader $downloader
     * @param Storage $storage
     */
    public function __construct(NetteFKSDBDownloader $downloader, Storage $storage) {
        $this->cache = new Cache($storage, static::class);
        $this->downloader = $downloader;
    }

    /**
     * @param Request $request
     * @param string $rootNodeName
     * @param string $cacheKey
     * @param string $modelClassName
     * @return array
     * @throws Throwable
     */
    protected function load(Request $request, string $rootNodeName, string $cacheKey, string $modelClassName): array {
        return $this->cache->load($cacheKey, function (&$dependencies) use ($request, $rootNodeName, $modelClassName): array {
            $dependencies[Cache::EXPIRE] = '1 second';
            $teams = [];
            $xml = $this->downloader->download($request);

            $doc = new DOMDocument();
            $doc->loadXML($xml);
            foreach ($doc->getElementsByTagName($rootNodeName) as $node) {
                $teams[] = $modelClassName::parseXML($node);
            }
            return $teams;
        });
    }
}
