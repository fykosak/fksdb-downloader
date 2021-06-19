<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;
/**
 * @property-read int $participantId;
 * @property-read int $schoolId;
 * @property-read string $name;
 * @property-read string $email;
 * @property-read string $schoolName;
 * @property-read string $countryIso;
 */
final class ModelParticipant extends AbstractSOAPModel {

    public static function getRows(): array {
        return [
            'participantId' => self::TYPE_INT,
            'schoolId' => self::TYPE_INT,
            'name' => self::TYPE_STRING,
            'email' => self::TYPE_STRING,
            'schoolName' => self::TYPE_STRING,
            'countryIso' => self::TYPE_STRING,
        ];
    }
}
