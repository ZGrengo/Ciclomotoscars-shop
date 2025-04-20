<?php
// Prevent multiple includes
if (!defined('INIT_LOADED')) {
    define('INIT_LOADED', true);
    
    // Include config first
    require_once __DIR__ . '/config.php';
    
    // Start session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Include other global files
    require_once __DIR__ . '/conexion.php';
}
?> 