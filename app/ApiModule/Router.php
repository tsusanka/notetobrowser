<?php

namespace App\Api;

use Nette\Application\Routers\RouteList;


class Router extends RouteList
{

	public function __construct($module = 'Api', $prefix = 'api')
	{
		parent::__construct($module);

		$this[] = new RestRoute($prefix . '/notes', 'Notes:', RestRoute::METHOD_GET);
		$this[] = new RestRoute($prefix . '/notes', 'Notes:add', RestRoute::METHOD_POST);
	}

}
