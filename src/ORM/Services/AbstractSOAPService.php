<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Services;

use DOMDocument;
use Fykosak\FKSDBDownloaderCore\Requests\Request;
use Fykosak\NetteFKSDBDownloader\NetteFKSDBDownloader;
use Fykosak\NetteFKSDBDownloader\ORM\Models\AbstractSOAPModel;
use Fykosak\NetteFKSDBDownloader\ORM\XMLParser;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\SmartObject;

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
     * @param mixed ...$args
     * @return array
     * @throws \Throwable
     */
    public function getAll(...$args): array {
        [$request, $rootNodeName, $modelClassName] = $this->getParams(...$args);
        return $this->cache->load($request->getCacheKey(), function (&$dependencies) use ($request, $rootNodeName, $modelClassName): array {
            $dependencies[Cache::EXPIRE] = '1 second';
            $items = [];
            $xml = $this->downloader->download($request);

            $doc = new DOMDocument();
            $doc->loadXML($xml);
            foreach ($doc->getElementsByTagName($rootNodeName) as $node) {
                $items[] = XMLParser::parseXMLNode($node, $modelClassName);
            }
            return $items;
        });
    }

    /**
     * @param mixed ...$args
     * @return Request[]
     */
    abstract protected function getParams(...$args): array;
}
