<?php

namespace App\Api;

use Nette\Application\Routers\Route;
use Nette\Http\IRequest;


/**
 * Route enhanced with HTTP verb matching
 * @see http://forum.nette.org/cs/4617-http-verbs-restful-architektura#p34558
 */
class RestRoute extends Route
{

	const METHOD_POST = 4;
	const METHOD_GET = 8;
	const METHOD_PUT = 16;
	const METHOD_DELETE = 32;
	const METHOD_PATCH = 64;
	const RESTFUL = 128;


	protected static $restDictionary = array(
		'GET' => 'default',
		'POST' => 'create',
		'PUT' => 'update',
		'DELETE' => 'delete'
	);


	public static function setRestDictionary(array $dictionary)
	{
		self::$restDictionary = array_merge(self::$restDictionary, $dictionary);
	}


	public function match(IRequest $httpRequest)
	{
		$httpMethod = $httpRequest->getMethod();

		if (!in_array($httpMethod, array('GET', 'POST', 'PUT', 'PATCH', 'DELETE')))
		{
			$httpMethod = 'GET';
		}

		if (($this->flags & self::RESTFUL) == self::RESTFUL)
		{
			$presenterRequest = parent::match($httpRequest);
			if ($presenterRequest != NULL) {
				$action = self::$restDictionary[$httpMethod];

				$params = $presenterRequest->getParameters();
				$params['action'] = $action;
				$presenterRequest->setParameters($params);
				return $presenterRequest;
			} else {
				return NULL;
			}
		}

		if (($this->flags & self::METHOD_GET) === self::METHOD_GET && $httpMethod !== 'GET')
		{
			return NULL;
		}

		if (($this->flags & self::METHOD_POST) === self::METHOD_POST && $httpMethod !== 'POST')
		{
			return NULL;
		}

		if (($this->flags & self::METHOD_PUT) === self::METHOD_PUT && $httpMethod !== 'PUT')
		{
			return NULL;
		}

		if (($this->flags & self::METHOD_DELETE) === self::METHOD_DELETE && $httpMethod !== 'DELETE')
		{
			return NULL;
		}

		if (($this->flags & self::METHOD_PATCH) === self::METHOD_PATCH && $httpMethod !== 'PATCH')
		{
			return NULL;
		}

		return parent::match($httpRequest);
	}

}
