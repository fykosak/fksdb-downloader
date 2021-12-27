<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use Nette\NotImplementedException;
use Nette\SmartObject;

abstract class AbstractSOAPModel
{
    use SmartObject;

    protected array $data = [];

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return static
     */
    public static function createFromArray(array $data): self
    {
        $model = new static();
        $model->setData($data);
        return $model;
    }

    /**
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * @param mixed $value
     */
    public function __set(string $name, $value): void
    {
        throw new NotImplementedException();
    }

    abstract public static function getRows(): array;
}
