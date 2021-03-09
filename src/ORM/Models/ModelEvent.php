<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTimeInterface;

final class ModelEvent extends AbstractSOAPModel {

    public int $eventId;
    public string $name;
    public int $eventYear;
    public DateTimeInterface $begin;
    public DateTimeInterface $end;
    public DateTimeInterface $registrationBegin;
    public DateTimeInterface $registrationEnd;
}
