<?php
/**
 * Router script for PHP built-in server (Admin)
 * Usage: php -S localhost:8889 admin/router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$_SERVER['PATH_INFO'] = $uri;
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/index.php';
