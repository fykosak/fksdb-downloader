<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

class ModelScheduleItem
{
    public int $scheduleItemId;
    public int $scheduleGroupId;

    public ?int $totalCapacity;
    public ?int $usedCapacity;

    public ?bool $requireIdNumber;

    /**
     * @var string[]|null
     */
    public ?array $label;

    /**
     * @var string[]|null
     */
    public ?array $description;

    /**
     * @var int[]|null
     */
    public ?array $price;
}
