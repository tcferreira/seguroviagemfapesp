<?php
/**
 * Router script for PHP built-in server (unified)
 * Usage: php -S localhost:8888 router.php
 *
 * Frontend: http://localhost:8888/
 * Admin:    http://localhost:8888/admin/
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// ── Admin panel ──────────────────────────────────────────────────
if (preg_match('#^/admin(?:/(.*))?$#', $uri, $matches)) {

    $adminPath = isset($matches[1]) ? $matches[1] : '';

    // Serve admin static files (CSS, JS, images from modules/comum/assets etc.)
    $staticFile = __DIR__ . '/admin/' . $adminPath;
    if ($adminPath !== '' && is_file($staticFile)) {
        // Determine MIME type
        $ext = pathinfo($staticFile, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'ico'  => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
            'eot'  => 'application/vnd.ms-fontobject',
            'map'  => 'application/json',
        ];
        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
        }
        readfile($staticFile);
        return;
    }

    // Also serve userfiles from project root
    if (preg_match('#^userfiles/(.+)$#', $adminPath, $ufm)) {
        $ufFile = __DIR__ . '/userfiles/' . $ufm[1];
        if (is_file($ufFile)) {
            $ext = strtolower(pathinfo($ufFile, PATHINFO_EXTENSION));
            $mimeTypes = [
                'png'  => 'image/png',
                'jpg'  => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'gif'  => 'image/gif',
                'svg'  => 'image/svg+xml',
                'webp' => 'image/webp',
                'pdf'  => 'application/pdf',
            ];
            header('Content-Type: ' . ($mimeTypes[$ext] ?? 'application/octet-stream'));
            readfile($ufFile);
            return;
        }
    }

    // CI routing — the admin CI expects REQUEST_URI without /admin prefix
    $ciUri = $adminPath ? '/' . $adminPath : '/';
    $_SERVER['REQUEST_URI'] = $ciUri;
    $_SERVER['PATH_INFO']   = $ciUri;
    $_SERVER['SCRIPT_NAME'] = '/index.php';

    // Tell admin config its base_url
    $_SERVER['ADMIN_BASE_URL'] = 'http://' . $_SERVER['HTTP_HOST'] . '/admin/';

    chdir(__DIR__ . '/admin');
    require __DIR__ . '/admin/index.php';
    return;
}

// ── Frontend static files ────────────────────────────────────────
if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

// ── Frontend CI routing ──────────────────────────────────────────
$_SERVER['PATH_INFO']   = $uri;
$_SERVER['SCRIPT_NAME'] = '/index.php';
require __DIR__ . '/index.php';
