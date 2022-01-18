<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

class ModelParticipant extends ModelPerson
{
    public ?int $schoolId = null;
    public ?string $schoolName = null;
    public ?string $countryIso = null;
}
