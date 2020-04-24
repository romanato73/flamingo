<?php

/**
 * Create message for log files
 *
 * @param string $message
 * @param null|string $prefix
 */
function writeLog($message, $prefix = null) {
    $logsPath = dirname($_SERVER['DOCUMENT_ROOT']) . '/logs/';
    $file = date('Y_m_d') . '_trace.log';
    $dateTime = date('Y-m-d H:i:s');
    $strToLog = is_null($prefix)
        ? "{$dateTime}\t{$message}\n"
        : "{$prefix} {$dateTime}\t\t{$message}\n";
    file_put_contents($logsPath . $file, $strToLog, FILE_APPEND | LOCK_EX);
}