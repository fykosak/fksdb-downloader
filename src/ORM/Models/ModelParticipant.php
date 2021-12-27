<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use Fykosak\NetteFKSDBDownloader\ORM\XMLParser;

/**
 * @property-read int $participantId;
 * @property-read int $schoolId;
 * @property-read string $name;
 * @property-read string $email;
 * @property-read string $schoolName;
 * @property-read string $countryIso;
 */
final class ModelParticipant extends AbstractSOAPModel
{
    public static function getRows(): array
    {
        return [
            'participantId' => XMLParser::TYPE_INT,
            'schoolId' => XMLParser::TYPE_INT,
            'name' => XMLParser::TYPE_STRING,
            'email' => XMLParser::TYPE_STRING,
            'schoolName' => XMLParser::TYPE_STRING,
            'countryIso' => XMLParser::TYPE_STRING,
        ];
    }
}
