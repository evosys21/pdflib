<?php

defined('TEST_PATH') || define('TEST_PATH', realpath(__DIR__));
date_default_timezone_set("Europe/Zurich");

require_once __DIR__ . '/../autoload.php';

echo shell_exec('php -v');

require 'BaseTestCase.php';
require 'BaseExamplesTestCase.php';
