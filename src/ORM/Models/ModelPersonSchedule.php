<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

class ModelPersonSchedule
{
    public ModelPerson $person;
    public int $scheduleItemId;
}
