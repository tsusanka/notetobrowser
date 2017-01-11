<?php

require __DIR__ . '/../vendor/autoload.php';

$root = dirname(__DIR__);
$params = [
	'rootDir' => $root,
	'appDir' => "$root/app",
	'logDir' => "$root/log",
];

$testTempDir = "$root/temp/tests";
Nette\Utils\FileSystem::createDir($testTempDir);

$configurator = new Nette\Configurator;
$configurator->setDebugMode(TRUE);
$configurator->setTempDirectory($testTempDir);
$configurator->createRobotLoader()
	->addDirectory($params['appDir'])
	->addDirectory("$root/tests/inc")
	->register();

$configurator->addConfig("$params[appDir]/config/config.neon");
$configurator->addConfig("$params[appDir]/config/config.local.neon");
$configurator->addConfig("$params[rootDir]/tests/inc/tests.neon");

$configurator->addParameters($params);

$container = $configurator->createContainer();

return $container;
