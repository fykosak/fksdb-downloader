<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

class ModelScheduleItem
{
    public int $scheduleItemId;
    public int $scheduleGroupId;

    public ?int $totalCapacity;
    public ?int $usedCapacity;

    /**
     * @var string[]|null
     */
    public ?array $name;

    /**
     * @var string[]|null
     */
    public ?array $description;

    /**
     * @var string[]|null
     */
    public ?array $longDescription;
    public ?array $price;

    public \DateTimeImmutable $begin;
    public \DateTimeImmutable $end;
}
