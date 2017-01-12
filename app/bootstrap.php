<?php

require __DIR__ . '/../vendor/autoload.php';


return function ($params = []) {
	$params += [
		'rootDir' => __DIR__ . '/..',
		'logDir' => __DIR__ . '/../log',
		'tempDir' => __DIR__ . '/../temp',
	];

	if (PHP_SAPI === 'cli') {
		// console has its own temp directory and always debug mode
		$params['tempDir'] = $params['tempDir'] . '/console';
		Nette\Utils\FileSystem::createDir($params['tempDir']);
		$params['debugMode'] = TRUE;
	}

	$configurator = new Nette\Configurator;
	$configurator->setDebugMode($params['debugMode']);
	$configurator->enableDebugger($params['logDir']);
	$configurator->setTempDirectory($params['tempDir']);
	$configurator->addParameters($params);
	$configurator->createRobotLoader()
		->addDirectory(__DIR__)
		->register();

	$configurator->addConfig(__DIR__ . '/config/config.neon');
	$configurator->addConfig(__DIR__ . '/config/config.local.neon');

	$container = $configurator->createContainer();

	// tests
	if ($configurator->isDebugMode() && isset($_GET['testDbName'])) {
		$container->getService('nextras.connection')->query('USE %table', $_GET['testDbName']);
		$container->parameters['database']['database'] = $_GET['testDbName'];
	}

	return $container;
};
