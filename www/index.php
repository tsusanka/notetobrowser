<?php

// Uncomment this line if you must temporarily take down your site for maintenance.
// require '.maintenance.php';

// Let bootstrap create Dependency Injection container.
$container = require __DIR__ . '/../app/bootstrap.php';

/** @var \Nette\DI\Container $dic */
$dic = $container(['debugMode' => \Nette\Configurator::detectDebugMode()]);

// Run application.
/** @var \Nette\Application\Application $app */
$app = $dic->getByType(Nette\Application\Application::class);
$app->run();
