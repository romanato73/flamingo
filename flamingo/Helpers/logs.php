<?php

if (!function_exists('writeLog')) {
    /**
     * Create a message inside log file
     *
     * @param string $message
     * @param null|string $prefix
     */
    function writeLog(string $message, $prefix = null) {
        // Make file name with current date
        $file = date('Y_m_d') . '_trace.log';
        // Initialize current date and time for message
        $dateTime = date('Y-m-d H:i:s');
        // Message to set
        $message = is_null($prefix)
            ? "{$dateTime}\t{$message}\n"
            : "{$prefix} {$dateTime}\t\t{$message}\n";
        // Check if file exists if no create one
        file_put_contents(LOGS_DIR . "/{$file}", $message, FILE_APPEND | LOCK_EX);
    }
}