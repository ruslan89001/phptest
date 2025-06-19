<?php
namespace app\core;

class Logger {
    private static $logPath = PROJECT_ROOT . '/logs/app.log';

    public static function log(string $message, string $level = 'INFO') {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents(self::$logPath, $logMessage, FILE_APPEND);
    }

    public static function error(string $message) {
        self::log($message, 'ERROR');
    }

    public static function info(string $message) {
        self::log($message, 'INFO');
    }

    public static function debug(string $message) {
        self::log($message, 'DEBUG');
    }
}