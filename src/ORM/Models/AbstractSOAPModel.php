<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTime;
use DOMNode;
use Exception;
use Nette\NotImplementedException;
use Nette\SmartObject;

abstract class AbstractSOAPModel {

    use SmartObject;

    protected const TYPE_STRING = 'string';
    protected const TYPE_INT = 'int';
    protected const TYPE_BOOL = 'bool';
    protected const TYPE_DATETIME = 'date-time';

    protected array $data = [];

    /**
     * @param array $data
     * @return static
     */
    public static function createFromArray(array $data): self {
        $model = new static();
        $model->setData($data);
        return $model;
    }

    /**
     * @param DOMNode $node
     * @return static
     * @throws Exception
     */
    public static function parseXML(DOMNode $node): self {
        $model = new static();
        $data = static::parseXMLNode($node, $model::getRows());
        $model->setData($data);
        return $model;
    }

    /**
     * @param DOMNode $node
     * @param mixed $rowDef
     * @return mixed
     * @throws Exception
     */
    public static function parseXMLNode(DOMNode $node, $rowDef) {
        if (is_array($rowDef)) {
            return static::parseVectorNode($node, $rowDef);
        } else {
            return static::parseScalarNode($node, $rowDef);
        }
    }

    /**
     * @param DOMNode $node
     * @param array $rowDefs
     * @return array
     * @throws Exception
     */
    protected static function parseVectorNode(DOMNode $node, array $rowDefs): array {
        $data = [];
        foreach ($node->childNodes as $childNode) {
            /** @var DOMNode $childNode */
            if ($childNode instanceof \DOMText) {
                continue;
            }
            $name = $childNode->nodeName;
            $parsedValue = static::parseXMLNode($childNode, $rowDefs[$name] ?? null);
            if ($parsedValue instanceof AbstractSOAPModel) {
                $data[$name] = $data[$name] ?? [];
                $data[$name][] = $parsedValue;
            } else {
                $data[$name] = $parsedValue;
            }
        }
        return $data;
    }

    /**
     * @param DOMNode $node
     * @param string|null $rowDef
     * @return bool|DateTime|int|string|null
     * @throws Exception
     */
    protected static function parseScalarNode(DOMNode $node, ?string $rowDef) {
        switch ($rowDef) {
            case self::TYPE_STRING;
                return (string)$node->nodeValue;
            case self::TYPE_INT;
                return (int)$node->nodeValue;
            case self::TYPE_DATETIME;
                return new DateTime($node->nodeValue);
            case self::TYPE_BOOL;
                return (bool)$node->nodeValue;
            default:
                return null;
        }
    }

    protected function setData(array $data): void {
        $this->data = $data;
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
