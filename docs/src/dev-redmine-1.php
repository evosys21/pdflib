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

$response = $client->wiki->all($project);
foreach ($response['wiki_pages'] as $page) {
    if (preg_match("/TCPDF|fpdf/i", $page['title'])) {
        print_r($page);
        $client->wiki->remove($project, $page['title']);
    }
}
