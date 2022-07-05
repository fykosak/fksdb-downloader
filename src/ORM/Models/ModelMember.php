<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

/**
 * Member is a person attendina a team event.
 */
class ModelMember extends ModelPerson
{
    public ?int $schoolId = null;
    public ?string $schoolName = null;
    public ?string $countryIso = null;
}
