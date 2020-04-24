<?php

use Flamingo\Exception\HttpException;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Cross-Site Request Forgery Protection
 */

// Create key for hash_hmac function
if (empty($_SESSION['csrf_key'])) {
    $_SESSION['csrf_key'] = bin2hex(random_bytes(32));
}

// Create CSRF token
$_SESSION['csrf'] = hash_hmac('sha256', 'Romanato is a really great guy!', $_SESSION['csrf_key']);

// Validate token
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (!isset($_POST['_csrf'])) {
            writeLog("CSRF Token is not set (URI:{$_SERVER['HTTP_REFERER']}", 'ERROR');
            throw new HttpException('CSRF Token is not set.');
        }
        if (!hash_equals($_SESSION['csrf'], $_POST['_csrf'])) {
            writeLog("Somebody tried to strike through CSRF Protection (URI:{$_SERVER['HTTP_REFERER']}). Nice try :-)", 'WARN');
            throw new HttpException('CSRF Token does not match!');
        }
    } catch (HttpException $exception) {
        die($exception->csrf());
    }

}

/**
 * Return CSRF token from SESSION
 *
 * @return mixed
 */
function csrf() {
    return $_SESSION['csrf'];
}