<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Application;

$publicDir = realpath(__DIR__ . '/public/');
if ($publicDir) {
    $requestPath = realpath($publicDir . $_SERVER['REQUEST_URI']);
    if (
        $requestPath
        && str_starts_with($requestPath, $publicDir)
        && file_exists($requestPath)
        && is_file($requestPath)
    ) {
        return false;
    }
}

chdir(__DIR__);
require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->getSlimApp()->run();
