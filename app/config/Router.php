<?php

namespace App;

use Nette\Application\Routers\Route;
use Nette\DI\Container;
use Nette\Application\Routers\RouteList;


class Router extends RouteList
{

	public function __construct(Container $context)
	{
		parent::__construct();

		$this[] = new Route('console/<command>/<subcommand>', 'Console:default');
		$this[] = new Api\Router();
		$this[] = new Front\Router();
	}

}
