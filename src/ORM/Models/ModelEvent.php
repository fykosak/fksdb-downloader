<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTimeInterface;
use Fykosak\NetteFKSDBDownloader\ORM\XMLParser;

/**
 * @property-read int $eventId;
 * @property-read string $name;
 * @property-read int $eventYear;
 * @property-read DateTimeInterface $begin;
 * @property-read DateTimeInterface $end;
 * @property-read DateTimeInterface $registrationBegin;
 * @property-read DateTimeInterface $registrationEnd;
 */
final class ModelEvent extends AbstractSOAPModel {

    public static function getRows(): array {
        return [
            'eventId' => XMLParser::TYPE_INT,
            'name' => XMLParser::TYPE_STRING,
            'eventYear' => XMLParser::TYPE_INT,
            'begin' => XMLParser::TYPE_DATETIME,
            'end' => XMLParser::TYPE_DATETIME,
            'registrationBegin' => XMLParser::TYPE_DATETIME,
            'registrationEnd' => XMLParser::TYPE_DATETIME,
        ];
    }
}
