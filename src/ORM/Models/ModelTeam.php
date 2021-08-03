<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTimeInterface;
use Fykosak\NetteFKSDBDownloader\ORM\XMLParser;

/**
 * @property-read int $teamId;
 * @property-read string $name;
 * @property-read string $status;
 * @property-read string $category;
 * @property-read DateTimeInterface $created;
 * @property-read ?string $phone = null;
 * @property-read ?string $password = null;
 * @property-read ?int $points = null;
 * @property-read ?int $rankCategory = null;
 * @property-read ?int $rankTotal = null;
 * @property-read bool $forceA;
 * @property-read ?string $gameLang = null;
 */
final class ModelTeam extends AbstractSOAPModel
{

    public static function getRows(): array
    {
        return [
            'teamId' => XMLParser::TYPE_INT,
            'name' => XMLParser::TYPE_STRING,
            'status' => XMLParser::TYPE_STRING,
            'category' => XMLParser::TYPE_STRING,
            'created' => XMLParser::TYPE_DATETIME,
            'phone' => XMLParser::TYPE_STRING,
            'password' => XMLParser::TYPE_STRING,
            'points' => XMLParser::TYPE_INT,
            'rankCategory' => XMLParser::TYPE_INT,
            'rankTotal' => XMLParser::TYPE_INT,
            'forceA' => XMLParser::TYPE_BOOL,
            'gameLang' => XMLParser::TYPE_STRING,
            'participant' => ModelParticipant::class,
        ];
    }

    public function setData(array $data): void
    {
        if (isset($data['participant'])) {
            $data['participants'] = $data['participant'];
            unset($data['participant']);
        }
        parent::setData($data);
    }
}
