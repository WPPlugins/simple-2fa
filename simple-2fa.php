<?php

/**
 * Plugin Name: Simple 2FA
 * Author: Popular Sizzle
 * Author URI: https://popularsizzle.com.au
 * Description: A lightweight, zero-config TOTP 2FA plugin with automatic rate limiting.
 * Version: 1.0.0
 */

namespace PopularSizzle\Plugins\Simple2FA;

defined('ABSPATH') || http_response_code(403) && exit;

require_once __DIR__ . '/src/autoload.php';
require_once __DIR__ . '/vendor/autoload.php';

Simple2FA::addHooks();

register_uninstall_hook(__FILE__, [Simple2FA::class, 'uninstall']);
