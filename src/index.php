<?php

use Zim32\TestTask\App\TestTaskApp;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/container.php';

(createContainer()->get(TestTaskApp::class)->run());
