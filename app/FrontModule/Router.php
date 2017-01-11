<?php

namespace App\Front;

use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;


class Router extends RouteList
{

	public function __construct($module = 'Front')
	{
		parent::__construct($module);

		$this[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
	}

}
