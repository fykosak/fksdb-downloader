<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

final class ModelParticipant extends AbstractSOAPModel {

    public int $participantId;
    public int $schoolId;
    public string $name;
    public string $email;
    public string $schoolName;
    public string $countryIso;
}
