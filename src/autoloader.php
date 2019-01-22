<?php
spl_autoload_register(function ($class) {
    if (strpos($class, 'Dcentrica\\') !== 0) {
        return;
    }
    $file = __DIR__ . str_replace('\\', DIRECTORY_SEPARATOR, substr($class, strlen('Dcentrica'))) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});
