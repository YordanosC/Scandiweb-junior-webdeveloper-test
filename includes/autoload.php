<?php

/**
 * used to automatically load class from models folder
 */
spl_autoload_register(function ($className) {
    $file = "../../models/" . $className . '.php';

    if (file_exists($file)) {
        include $file;
    }
});

spl_autoload_register(function ($className) {
    $db = "../../config/" . $className . '.php';

    if (file_exists($db)) {
        include $db;
    }
});