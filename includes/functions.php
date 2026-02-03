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

    $uri = $_SERVER['REQUEST_URI'];

    // Remove query string
    if (strpos($uri, '?') !== false) {
        $uri = substr($uri, 0, strpos($uri, '?'));
    }

    // Automatically detect subdirectory if any
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    if ($scriptDir !== '/' && strpos($uri, $scriptDir) === 0) {
        $uri = substr($uri, strlen($scriptDir));
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

/**
 * Get Client IP Address
 */
function get_client_ip()
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }
    return $ip;
}

/**
 * Get Client Demographics via IP-API
 */
function get_client_demographics($ip)
{
    if (session_status() === PHP_SESSION_NONE)
        session_start();

    // Only return cache if it's not "Unknown" 
    if (isset($_SESSION['geo_cache'][$ip]) && $_SESSION['geo_cache'][$ip]['country'] !== 'Unknown') {
        return $_SESSION['geo_cache'][$ip];
    }

    $geo = ['country' => 'Unknown', 'city' => 'Unknown'];

    // Handle Localhost/Internal
    if ($ip === '127.0.0.1' || $ip === '::1' || strpos($ip, '192.168.') === 0 || strpos($ip, '10.') === 0) {
        $geo = ['country' => 'Local Network', 'city' => 'Internal (Localhost)'];
    } elseif ($ip !== 'Unknown') {
        try {
            $ctx = stream_context_create(['http' => ['timeout' => 2]]);
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,message,country,regionName,city", false, $ctx);
            if ($response) {
                $data = json_decode($response, true);
                if ($data && ($data['status'] ?? '') === 'success') {
                    $geo['country'] = $data['country'] ?? 'Unknown';
                    $city = $data['city'] ?? '';
                    $reg = $data['regionName'] ?? '';
                    $geo['city'] = trim($city . ($reg ? ", $reg" : "")) ?: 'Unknown';
                }
            }
        } catch (Exception $e) {
        }
    }

    // Only cache if we found something useful
    if ($geo['country'] !== 'Unknown') {
        $_SESSION['geo_cache'][$ip] = $geo;
    }

    return $geo;
}

/**
 * Basic User Agent Parser
 */
function get_client_ua_info()
{
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $os = "Other";
    $browser = "Other";
    $device = "Desktop";

    // Detect OS
    if (preg_match('/windows|win32/i', $ua))
        $os = 'Windows';
    elseif (preg_match('/macintosh|mac os x/i', $ua))
        $os = 'macOS';
    elseif (preg_match('/linux/i', $ua))
        $os = 'Linux';
    elseif (preg_match('/iphone|ipad|ipod/i', $ua))
        $os = 'iOS';
    elseif (preg_match('/android/i', $ua))
        $os = 'Android';

    // Detect Browser
    if (preg_match('/msie/i', $ua) && !preg_match('/opera/i', $ua))
        $browser = 'IE';
    elseif (preg_match('/firefox/i', $ua))
        $browser = 'Firefox';
    elseif (preg_match('/chrome/i', $ua))
        $browser = 'Chrome';
    elseif (preg_match('/safari/i', $ua))
        $browser = 'Safari';
    elseif (preg_match('/opera/i', $ua))
        $browser = 'Opera';

    // Detect Device
    if (preg_match('/mobile|phone|android|silk/i', $ua))
        $device = 'Mobile';
    elseif (preg_match('/tablet|ipad/i', $ua))
        $device = 'Tablet';

    return ['os' => $os, 'browser' => $browser, 'device' => $device, 'ua_raw' => $ua];
}

/**
 * Check if tool is "New" (Created in last 14 days)
 */
function is_new_tool($createdAt)
{
    if (!$createdAt)
        return false;
    $created = strtotime($createdAt);
    $now = time();
    $diff = $now - $created;
    return $diff < (14 * 24 * 60 * 60); // 14 days
}
