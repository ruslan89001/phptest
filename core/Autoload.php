<?php

spl_autoload_register(function ($className) {
    $file = str_replace('app\\', PROJECT_ROOT . '/app/', $className) . '.php';
    $file = str_replace('\\', '/', $file);

    if (file_exists($file)) {
        require $file;
    }
});