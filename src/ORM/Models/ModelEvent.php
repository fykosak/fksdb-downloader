<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

class ModelEvent
{
    public int $eventId;
    public int $eventTypeId;
    public string $name;
    /**
     * @var string[]
     */
    public array $nameNew;
    public int $eventYear;
    public int $year;
    public ?string $report;

    /**
     * @var string[]
     */
    public array $reportNew;

    /**
     * @var string[]
     */
    public array $description;

    public \DateTimeImmutable $begin;
    public \DateTimeImmutable $end;
    public \DateTimeImmutable $registrationBegin;
    public \DateTimeImmutable $registrationEnd;
}
