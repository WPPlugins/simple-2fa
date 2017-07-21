<?php

namespace PopularSizzle\Plugins\Simple2FA;

class Singleton
{

    protected $hook_namespace;
    private static $instances;

    public static function getInstance()
    {
        $class_name = get_called_class();

        if (!isset(self::$instances[$class_name])) {
            $class = new static;
            $class->hook_namespace = str_replace('\\', '/', __NAMESPACE__);

            self::$instances[$class_name] = $class;
        }

        return self::$instances[$class_name];
    }

    private function __construct() {}
    private function __clone() {}

}
