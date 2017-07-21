<?php

namespace PopularSizzle\Plugins\Simple2FA;

class Simple2FA extends Singleton
{

    private static $hooks = [
        [
            'tag' => 'login_form',
            'class' => 'Views',
            'method' => 'loginForm',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'login_message',
            'class' => 'Views',
            'method' => 'loginMessage',
            'priority' => 10,
            'arg_count' => 1
        ],

        [
            'tag' => 'admin_init',
            'class' => 'User',
            'method' => 'onboardRedirect',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'wp_ajax_simple_2fa_onboard',
            'class' => 'Views',
            'method' => 'onboardPage',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'wp_ajax_simple_2fa_qrcode',
            'class' => 'Views',
            'method' => 'qrcodeImage',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'wp_ajax_simple_2fa_enable',
            'class' => 'User',
            'method' => 'enable',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'authenticate',
            'class' => 'Throttle',
            'method' => 'check',
            'priority' => 0,
            'arg_count' => 2
        ],

        [
            'tag' => 'authenticate',
            'class' => 'User',
            'method' => 'authenticate',
            'priority' => 100,
            'arg_count' => 2
        ],

        [
            'tag' => 'authenticate',
            'class' => 'Throttle',
            'method' => 'updateAttempts',
            'priority' => PHP_INT_MAX,
            'arg_count' => 2
        ],

        [
            'tag' => 'show_user_profile',
            'class' => 'Views',
            'method' => 'userReset',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'edit_user_profile',
            'class' => 'Views',
            'method' => 'userReset',
            'priority' => 10,
            'arg_count' => 0
        ],

        [
            'tag' => 'wp_ajax_simple_2fa_reset',
            'class' => 'User',
            'method' => 'reset',
            'priority' => 10,
            'arg_count' => 0
        ]
    ];

    public static function addHooks()
    {
        foreach (self::$hooks as $i => $hook) {
            extract($hook);

            add_filter($tag, [__CLASS__, 'hook' . $i], $priority, $arg_count);
        }
    }

    public static function __callStatic($called, $arguments)
    {
        if (preg_match('/hook[0-9]+$/', $called)) {
            $hook = substr($called, 4);

            $class = __NAMESPACE__ . '\\' . self::$hooks[$hook]['class'];
            $method = self::$hooks[$hook]['method'];

            return call_user_func_array([$class::getInstance(), $method], $arguments);
        }
    }

    public static function uninstall()
    {
        $users = get_users([
            'fields' => ['ID']
        ]);

        foreach ($users as $user) {
            User::getInstance()->deleteMeta($user->ID);
        }
    }

}
