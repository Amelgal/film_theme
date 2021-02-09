<?php

namespace Cactus\Bootstrap;

/**
 * Class Bootstrap
 * @package Cactus
 */
class Bootstrap
{

    /**
     * @var array
     */
    public static $objects = [];

    /**
     * Bootstrap constructor.
     *
     * @param array $config Configuration.
     *
     * @return void
     */
    public static function load($config = [])
    {
        foreach ($config as $key => $class) {
            self::get($class, $key);
        }
    }

    /**
     * Get class object.
     *
     * @param string $className The name of the class.
     * @param string $alias The alias of the class.
     *
     * @return object|null
     */
    public static function get($className, $alias = '')
    {
        if (isset(self::$objects[$className])) {
            return self::$objects[$className];
        }

        $objects = array_filter(
            self::$objects,
            function ($object) use ($className) {
                return get_class($object) == trim($className, '\/');
            }
        );

        $object = current($objects);

        if ($object) {
            return $object;
        } else {
            if (class_exists($className)) {
                $object = new $className;

                if (!empty($alias)) {
                    self::$objects[$alias] = $object;
                } else {
                    self::$objects[] = $object;
                }

                return $object;
            }
        }

        return null;
    }
}
