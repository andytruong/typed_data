<?php

$locations[] = __DIR__ . "/../vendor/autoload.php";
$locations[] = __DIR__ . "/../../../autoload.php";

foreach ($locations as $location) {
    if (is_file($location)) {
        $loader = require $location;
        $loader->addPsr4('AndyTruong\\TypedData\\TestCases\\', __DIR__ . '/typed_data');
        $loader->addPsr4('AndyTruong\\TypedData\\', __DIR__ . '/../src');
        break;
    }
}
