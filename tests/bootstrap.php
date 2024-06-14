<?php

defined('TEST_PATH') || define('TEST_PATH', realpath(__DIR__));
$_SERVER['ENVIRONMENT'] = 'test';

date_default_timezone_set("Europe/Zurich");

require_once __DIR__ . '/../autoload.php';

require 'BaseTestCase.php';
require 'BaseExamplesTestCase.php';
