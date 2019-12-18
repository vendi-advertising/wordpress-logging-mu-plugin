<?php
/*
Plugin Name: Vendi - WordPress Logging
Description: Site-wide PSR-3 logging
Version: 1.0.0
Author: Vendi Advertising (Chris Haas)
*/

if (!defined('ABSPATH')) {
    exit;
}

$plugin_dir = __DIR__ . '/vendi-wordpress-logging-mu-plugin/';
$boot_file = $plugin_dir . '/vendor/autoload.php';
$logging_dir = $plugin_dir . '/.logs/';

if (!is_readable($boot_file)) {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }
    throw new RuntimeException('Please run composer install to enable global logging');
}

require_once $boot_file;

if (!defined('Inpsyde\Wonolog\LOG')) {
    if (!defined('WP_DEBUG') || !WP_DEBUG) {
        return;
    }
    throw new RuntimeException('Could not find Wonolog library for global logging');
}

/** @noinspection PhpUndefinedFunctionInspection */
add_filter(
    'wonolog.default-handler-folder',
    static function () use ($logging_dir) {
        return $logging_dir;
    }
);
Inpsyde\Wonolog\bootstrap();
