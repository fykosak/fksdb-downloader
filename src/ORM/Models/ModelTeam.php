<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTimeInterface;
use DOMNode;

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
final class ModelTeam extends AbstractSOAPModel {

    public static function getRows(): array {
        return [
            'teamId' => self::TYPE_INT,
            'name' => self::TYPE_STRING,
            'status' => self::TYPE_STRING,
            'category' => self::TYPE_STRING,
            'created' => self::TYPE_DATETIME,
            'phone' => self::TYPE_STRING,
            'password' => self::TYPE_STRING,
            'points' => self::TYPE_INT,
            'rankCategory' => self::TYPE_INT,
            'rankTotal' => self::TYPE_INT,
            'forceA' => self::TYPE_BOOL,
            'gameLang' => self::TYPE_STRING,
            'participant' => ModelParticipant::class,
        ];
    }

    public static function parseXMLNode(DOMNode $node, $rowDef) {
        if ($rowDef === ModelParticipant::class) {
            return ModelParticipant::parseXML($node);
        }
        return parent::parseXMLNode($node, $rowDef);
    }

    protected function setData(array $data): void {
        if (isset($data['participant'])) {
            $data['participants'] = $data['participant'];
            unset($data['participant']);
        }
        parent::setData($data);
    }

}
