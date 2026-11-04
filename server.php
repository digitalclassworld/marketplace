<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * Emulates Apache "mod_rewrite" functionality for the built-in PHP web server.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve the static file if it exists
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

require_once __DIR__ . '/public/index.php';

