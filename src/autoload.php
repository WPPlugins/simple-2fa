<?php

namespace PopularSizzle\Plugins\Simple2FA;

spl_autoload_register(function($class) {
    $length = strlen(__NAMESPACE__);

    if (strncmp(__NAMESPACE__, $class, $length) == 0) {
        $include = __DIR__ . str_replace('\\', '/', substr($class, $length)) . '.php';

        if (file_exists($include)) {
            require_once $include;
        }
    }
});
