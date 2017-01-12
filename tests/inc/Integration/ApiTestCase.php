<?php

namespace Tests\Integration\Api;

use Tests\Integration\IntegrationTestCase;
use App\Api\ApiResponse;
use Nette\Utils\Json;


abstract class ApiTestCase extends IntegrationTestCase
{

	/** @var [] */
	protected $failingHeaders;

	/** @var [] */
	protected $passingHeaders;


	protected function setUp()
	{
		parent::setUp();

		$this->failingHeaders = array(
			'Accept: application/json',
			'X-Api-Token: error',
		);
		$this->passingHeaders = array(
			'Accept: application/json',
			'X-Api-Token: ' . $this->context->parameters['api']['secretToken'],
		);
	}

	/**
	 * @param string $method HTTP method
	 * @param string $action
	 * @param array|NULL $query GET parameters
	 * @param array|NULL $headers HTTP headers
	 * @return \stdClass
	 */
	protected function sendApiRequest($method, $action, $query = NULL, $headers = NULL)
	{
		$url = $this->context->parameters['host'] . 'api/' . $action;
		if ($method === 'GET' || $method === 'DELETE') {
			$query['testDbName'] = $this->context->parameters['testDbName'];
			$url .= ($q = http_build_query($query)) ? ('?' . $q) : '';
			$data = NULL;
		} else {
			$url .= '?' . 'testDbName=' . $this->context->parameters['testDbName'];
			$data = $query = Json::encode($query);
		}

		if (!$headers) {
			$headers = $this->passingHeaders;
		}

		$curl = curl_init($url);
		curl_setopt_array($curl, [
			CURLOPT_CUSTOMREQUEST => $method,
			CURLOPT_HTTPHEADER => $headers ?: [],
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_HEADER => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
		]);
		$response = explode("\r\n\r\n", curl_exec($curl), 2);

		$responseHeaders = explode("\r\n", $response[0]);
		$return = (object)[
			'code' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
			'headers' => $responseHeaders,
			'body' => json_decode($response[1]),
			'raw' => $response[1],
		];

		return $return;
	}

	/**
	 * Assert 2xx response code
	 *
	 * @param $response
	 * @param string $responseCode
	 * @param string $contentType
	 */
	protected function assertSuccessResponse($response, $responseCode = ApiResponse::S200_OK, $contentType = 'application/json')
	{
		if (isset($contentType)) {
			$ct = 'Content-Type: ' . $contentType . '; charset=utf-8';
			$this->assertTrue(is_numeric(array_search($ct, $response->headers)), 'Wrong response content type. "' . $contentType . '" was expected');
		}
		$this->assertEquals($responseCode, $response->code, 'Success response was expected');
	}

	/**
	 * Assert 4xx or 5xx response code
	 *
	 * @param StdClass
	 * @param int
	 */
	protected function assertErrorResponse($response, $errorCode)
	{
		$responseCode = (int)substr($errorCode, 0, 3);
		$this->assertEquals($responseCode, $response->code, 'Error response was expected');
	}

}
