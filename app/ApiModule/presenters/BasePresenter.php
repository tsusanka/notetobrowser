<?php

namespace App\Api;

use Nette\Utils\JsonException;
use Nette\Utils\Json;
use App;
use App\BasePresenter as RootBasePresenter;


/**
 * API base presenter
 */
abstract class BasePresenter extends RootBasePresenter
{

	/** @var array returned data */
	protected $payload = array();

	/** @var \StdClass requested data from JSON */
	protected $data;


	public function startup()
	{
		parent::startup();

		$apiParams = $this->context->parameters['api'];
		if ($apiParams['secretToken'] !== NULL && $apiParams['secretToken'] !== $this->getHttpRequest()->getHeader('X-Api-Token')) {
			$this->sendErrorResponse(ApiResponse::S401_UNAUTHORIZED, 'Authorization failed, wrong secret api token.');
		}

		$requestParams = $this->request->getParameters();
		$this->prepareData(file_get_contents('php://input'));
	}

	/**
	 * Sends response and terminates
	 *
	 * @param array|NULL
	 * @param int|string|NULL
	 */
	protected function sendSuccessResponse($data = NULL, $responseCode = ApiResponse::S200_OK)
	{
		if ($data !== NULL) {
			$this->payload = $data;
		}

		$this->filterData($this->payload);
		$this->sendResponse(new ApiResponse($this->payload, $responseCode));
	}

	/**
	 * Removes NULLs, formats DateTime
	 */
	private function filterData(&$data)
	{
		foreach ($data as $key => &$value) {
			if ($value === NULL) {
				unset($data[$key]);

			} elseif ($value instanceof \DateTime) {
				$value = $value->format('Y-m-d\\TH:i:sP');

			} elseif (is_array($value)) {
				$this->filterData($value);
			}
		}
	}

	private function prepareData($rawPostData)
	{
		if (!$rawPostData) {
			$this->data = NULL;
			return;
		}

		try {
			$post = Json::decode($rawPostData);

		} catch (JsonException $e) {
			$this->sendErrorResponse(ApiResponse::S404_5_WRONG_ARGUMENTS);
			exit;
		}

		$this->data = $post;
	}

	/**
	 * Sends error response and terminates
	 *
	 * @param int $errorCode
	 * @param string
	 */
	protected function sendErrorResponse($errorCode, $message = '')
	{
		$this->sendResponse(new ApiResponse(array('message' => $message), $errorCode));
	}

}
