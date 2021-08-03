<?php

declare(strict_types=1);

namespace Fykosak\NetteFKSDBDownloader\ORM;

use Fykosak\NetteFKSDBDownloader\ORM\Models\AbstractSOAPModel;

class XMLParser
{

    public const TYPE_STRING = 'string';
    public const TYPE_INT = 'int';
    public const TYPE_BOOL = 'bool';
    public const TYPE_DATETIME = 'date-time';

    /**
     * @param \DOMNode $node
     * @param mixed $rowDef
     * @return mixed
     * @throws \Exception
     */
    public static function parseXMLNode(\DOMNode $node, $rowDef)
    {
        if (is_array($rowDef)) {
            return static::parseVectorNode($node, $rowDef);
        } else {
            return static::parseScalarNode($node, $rowDef);
        }
    }

    /**
     * @param \DOMNode $node
     * @param array $rowDefs
     * @return array
     * @throws \Exception
     */
    public static function parseVectorNode(\DOMNode $node, array $rowDefs): array
    {
        $data = [];
        foreach ($node->childNodes as $childNode) {
            /** @var \DOMNode $childNode */
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
     * @param \DOMNode $node
     * @param AbstractSOAPModel|string|null $rowDef
     * @return bool|\DateTime|int|string|null
     * @throws \Exception
     */
    public static function parseScalarNode(\DOMNode $node, ?string $rowDef)
    {
        if (is_string($rowDef) && class_exists($rowDef)) {
            $rf = new \ReflectionClass($rowDef);
            if ($rf->isSubclassOf(AbstractSOAPModel::class)) {
                $data = XMLParser::parseXMLNode($node, $rowDef::getRows());
                return $rowDef::createFromArray($data);
            }
        }
        switch ($rowDef) {
            case self::TYPE_STRING;
                return (string)$node->nodeValue;
            case self::TYPE_INT;
                return (int)$node->nodeValue;
            case self::TYPE_DATETIME;
                return new \DateTime($node->nodeValue);
            case self::TYPE_BOOL;
                return (bool)$node->nodeValue;
            default:
                return null;
        }
    }
}
