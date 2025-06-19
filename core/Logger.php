<?php
namespace app\core;

class Logger {
    private static string $logPath = '';

    public static function init(): void {
        self::$logPath = PROJECT_ROOT . '/logs/app.log';
        if (!file_exists(dirname(self::$logPath))) {
            mkdir(dirname(self::$logPath), 0755, true);
        }
    }

    public static function log(string $message, string $level = 'INFO'): void {
        self::init();
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] [$level] $message" . PHP_EOL;
        file_put_contents(self::$logPath, $logMessage, FILE_APPEND);
    }

    public static function error(string $message): void {
        self::log($message, 'ERROR');
    }

    public static function info(string $message): void {
        self::log($message, 'INFO');
    }

    public static function debug(string $message): void {
        self::log($message, 'DEBUG');
    }
}