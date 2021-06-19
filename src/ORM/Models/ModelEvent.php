<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTimeInterface;

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
            'eventId' => self::TYPE_INT,
            'name' => self::TYPE_STRING,
            'eventYear' => self::TYPE_INT,
            'begin' => self::TYPE_DATETIME,
            'end' => self::TYPE_DATETIME,
            'registrationBegin' => self::TYPE_DATETIME,
            'registrationEnd' => self::TYPE_DATETIME,
        ];
    }
}
