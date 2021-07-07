<?php

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$config = Setup::createXMLMetadataConfiguration([__DIR__."/xml"], $isDevMode, null, null, false);

$entityManager = EntityManager::create([
    'driver' => 'pdo_sqlite',
    'path' => getenv('TESTBUCKET_DIR'),
], $config);
