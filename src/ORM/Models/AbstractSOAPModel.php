<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use Nette\NotImplementedException;
use Nette\SmartObject;

abstract class AbstractSOAPModel {

    use SmartObject;

    protected array $data = [];

    public function setData(array $data): void {
        $this->data = $data;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function createFromArray(array $data): self {
        $model = new static();
        $model->setData($data);
        return $model;
    }

    public function __get(string $name) {
        return $this->data[$name] ?? null;
    }

    public function __isset(string $name): bool {
        return isset($this->data[$name]);
    }

    public function __set(string $name, $value): void {
        throw new NotImplementedException();
    }

    abstract public static function getRows(): array;
}
