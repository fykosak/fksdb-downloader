<?php

namespace Fykosak\FKSDBDownloader\Downloader;

use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\SmartObject;
use SoapClient;
use SoapFault;
use SoapHeader;
use stdClass;

class Downloader {
    use SmartObject;

    private SoapClient $client;
    private Cache $cache;
    private int $eventTypeId;

    /**
     * Downloader constructor.
     * @param string $wsdl
     * @param string $username
     * @param string $password
     * @param int $eventTypeId
     * @param IStorage $storage
     * @throws SoapFault
     */
    public function __construct(string $wsdl, string $username, string $password, int $eventTypeId, IStorage $storage) {
        $this->eventTypeId = $eventTypeId;
        $this->cache = new Cache($storage, self::class);

        $this->client = new SoapClient($wsdl, [
            'trace' => true,
            'exceptions' => true,
            'stream_context' => stream_context_create(
                [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]),
        ]);

        $credentials = new stdClass();
        $credentials->username = $username;
        $credentials->password = $password;

        $header = new SoapHeader('http://fykos.cz/xml/ws/service', 'AuthenticationCredentials', $credentials);
        $headers = [$header];
        $this->client->__setSoapHeaders($headers);
    }

    public function createTeamList(int $eventId): string {
        return $this->download('teamList.' . $eventId, 'GetEvent', [
            'teamList' => '',
            'eventId' => $eventId,
        ]);
    }

    public function createEventList(): string {
        return $this->download('eventList', 'GetEvent', [
            'eventList' => '',
            'eventTypeId' => $this->eventTypeId,
        ]);
    }

    /**
     * @param string $cacheKey
     * @param string $methodName
     * @param mixed $request
     * @return string response XML
     */
    public function download(string $cacheKey, string $methodName, array $request): string {
        return $this->cache->load($cacheKey, function (&$dependencies) use ($methodName, $request) {
            $dependencies[Cache::EXPIRE] = '20 minutes';
            $this->client->{$methodName}($request);
            return $this->client->__getLastResponse();
        });
    }
}
