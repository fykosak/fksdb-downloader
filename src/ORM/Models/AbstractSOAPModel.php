<?php

namespace Fykosak\NetteFKSDBDownloader\ORM\Models;

use DateTime;
use DOMNode;
use Exception;
use Nette\SmartObject;
use Nette\Utils\Reflection;
use ReflectionException;
use ReflectionProperty;

abstract class AbstractSOAPModel {
    use SmartObject;

    /**
     * @param DOMNode $node
     * @return static
     * @throws Exception
     */
    public static function createFromXMLNode(DOMNode $node): self {
        $model = new static();
        /** @var DOMNode $value */
        foreach ($node->childNodes as $value) {
            if (static::handleAccessNode($value, $model)) {
                continue;
            }
            try {
                $type = Reflection::getPropertyType(new ReflectionProperty(static::class, $value->nodeName));
                switch ($type) {
                    case 'string';
                        $model->{$value->nodeName} = (string)$value->nodeValue;
                        break;
                    case 'int';
                        $model->{$value->nodeName} = (int)$value->nodeValue;
                        break;
                    case 'DateTimeInterface';
                        $model->{$value->nodeName} = new DateTime($value->nodeValue);
                        break;
                    case 'bool';
                        $model->{$value->nodeName} = (bool)$value->nodeValue;
                        break;
                    default:
                        break;
                }
            } catch (ReflectionException$exception) {
            }
        }
        return $model;
    }

    static protected function handleAccessNode(DOMNode $node, self $model): bool {
        return false;
    }
}
