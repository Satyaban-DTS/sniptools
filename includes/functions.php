<?php
// web/includes/functions.php

/**
 * Simple ID Encryption/Obfuscation
 */
function encryptId($id)
{
    $salt = "sniptools_secret_key_2026";
    $hash = md5($salt . $id);
    return substr($hash, 0, 8) . dechex($id + 5000);
}

/**
 * Simple ID Decryption/De-obfuscation
 */
function decryptId($encryptedId)
{
    if (strlen($encryptedId) < 9)
        return null;
    $hex = substr($encryptedId, 8);
    return hexdec($hex) - 5000;
}

/**
 * Generate Clean URL
 */
function url($path = '')
{
    $baseUrl = rtrim(BASE_URL, '/');
    return $baseUrl . '/' . ltrim($path, '/');
}

/**
 * Get hierarchy based Tool URL
 */
function getToolUrl($slug, $tool)
{
    $catSlug = $tool['category'] ?? 'uncategorized';
    return url("tools/{$catSlug}/{$slug}");
}

/**
 * Get Clean Route
 */
function getRoute()
{
    if (isset($_GET['route'])) {
        return $_GET['route'];
    }

    // Support PHP built-in server and other environments
    $uri = $_SERVER['REQUEST_URI'];

    // Remove query string
    if (strpos($uri, '?') !== false) {
        $uri = substr($uri, 0, strpos($uri, '?'));
    }

    // Remove base path (/web)
    $basePath = rtrim(BASE_URL, '/');
    if (!empty($basePath) && strpos($uri, $basePath) === 0) {
        $uri = substr($uri, strlen($basePath));
    }

    return trim($uri, '/');
}

/**
 * Set flash message to session
 */
function set_flash_message($message, $type = 'success')
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

/**
 * Get flash message from session
 */
function get_flash_message()
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();
    if (isset($_SESSION['flash_message'])) {
        $flash = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $flash;
    }
    return null;
}
