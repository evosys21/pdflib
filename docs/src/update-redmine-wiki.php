<?php

$APP_DIR = __DIR__ . '/../..';

chdir($APP_DIR);

require_once 'autoload.php';

use \Interpid\Redmine\RedmineWiki;

$dotEnv = Dotenv\Dotenv::createImmutable($APP_DIR);
$dotEnv->load();

$project = getenv('REDMINE_PROJECT');
$prefix = '';

$client = new Redmine\Client(getenv('REDMINE_URL'), getenv('REDMINE_API_KEY'));

$redmineWiki = new RedmineWiki($client, $project, $prefix);
$redmineWiki->wikiPages(__DIR__ . '/pages-wiki.json');
//$redmineWiki->wikiPages(__DIR__ . '/pages-multicell-examples.json');
//$redmineWiki->wikiPages(__DIR__ . '/pages-table-examples.json');
