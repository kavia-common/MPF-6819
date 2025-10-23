<?php
/**
 * Lightweight built-in server bootstrap for MPF.
 * Binds to 0.0.0.0:3001 and routes all requests through index.php,
 * while serving static files directly when they exist.
 *
 * Usage (handled by preview system): php -S 0.0.0.0:3001 server.php
 */

// Serve static files if they exist
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$fullPath = __DIR__ . $path;

// Prevent serving PHP source files as text
$forbiddenExtensions = ['php', 'php5', 'phtml'];
$ext = pathinfo($fullPath, PATHINFO_EXTENSION);
if (in_array(strtolower($ext), $forbiddenExtensions, true)) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo "403 Forbidden";
    return true;
}

// If the request directly maps to an existing file, let the built-in server serve it
if ($path !== '/' && file_exists($fullPath) && is_file($fullPath)) {
    return false;
}

// Otherwise, route everything through index.php
require __DIR__ . '/index.php';
