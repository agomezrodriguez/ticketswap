<?php
/**
 * Created by PhpStorm.
 * User: agomez
 * Date: 13/08/16
 * Time: 23:29
 */

namespace Ticketswap\CommonBundle\Util;

use Doctrine\Common\Util\Inflector;

class Binder
{
    private function __construct()
    {
    }

    public static function jsonBind($jsonData, $target, $camelize = false)
    {
        return self::bind(json_decode($jsonData, true), $target, $camelize);
    }

    public static function bind(array $data, $target, $camelize = false)
    {
        if (!is_object($target)) {
            throw new \InvalidArgumentException('$target must be an object');
        }

        $ref = new \ReflectionObject($target);
        foreach ($data as $key => $value) {
            $propertyName = $camelize ? Inflector::camelize($key) : $key;
            $methodName = 'set' . ucfirst($propertyName);

            if ($ref->hasMethod($methodName) && $ref->getMethod($methodName)->isPublic()) {
                $target->$methodName($value);
            } else if ($ref->hasProperty($propertyName) && $ref->getProperty($propertyName)->isPublic()) {
                $target->$propertyName = $value;
            }
        }

        return $target;
    }
}
