<?php

declare(strict_types=1);

use Scottaubrey\True9PaydaySystem\Application;

chdir(__DIR__);
require_once __DIR__ . '/vendor/autoload.php';

$app = new Application();
$app->getSlimApp()->run();
