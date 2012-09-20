<?php
spl_autoload_register(function($class) {
    $dir   = dirname(__DIR__);
    $file  = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    $src = $dir . DIRECTORY_SEPARATOR . 'src'. DIRECTORY_SEPARATOR . $file;
    if (file_exists($src)) {
        require $src;
    }
    $vendor = $dir . DIRECTORY_SEPARATOR . 'vendor'. DIRECTORY_SEPARATOR
        . dirname($file) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
        . $file;
    if (file_exists($vendor)) {
        require $vendor;
    }
    $tests = $dir . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . $file;
    if (file_exists($tests)) {
        require $tests;
    }
});
