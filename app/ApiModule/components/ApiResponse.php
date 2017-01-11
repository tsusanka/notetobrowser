<?php

namespace App\Api;

use Nette\Http\IResponse;
use Nette\Http\IRequest;
use Nette\Application\Responses\JsonResponse;


/**
 * API response
 */
class ApiResponse extends JsonResponse
{

	const
		S200_OK = '200', // OK odpověď na GET
		S201_CREATED = '201', // OK odpověď na POST/PUT
		S204_NO_CONTENT = '204', // OK odpověď na DELETE

		S300_MULTIPLE_CHOICES = '300', // OK. více výsledků
		S303_SEE_OTHER = '303', // OK. přesměrování při synchronizaci
		S304_NOT_MODIFIED = '304', // OK. odpověď na If-Modified-Since

		S400_BAD_REQUEST = '400', // špatná data požadavku
		S401_UNAUTHORIZED = '401', // neautorizován
		S403_FORBIDDEN = '403', // nepovolený přístup
		S403_1_SSL_REQUIRED = '403.1', // SSL vyžadováno

		S404_NOT_FOUND = '404', // nenalezeno
		S404_1_PLAYER_NOT_FOUND = '404.1', // nenalezen
		S404_2_LANGUAGE_NOT_FOUND = '404.2', // nenalezen
		S404_3_QUESTION_NOT_FOUND = '404.3', // nenalezen
		S404_5_WRONG_ARGUMENTS = '404.5',

		S405_METHOD_NOT_ALLOWED = '405', // metodu nelze na dané URL použít
		S409_CONFLICT = '409', // rekvest koliduje se stavem aplikace, ale jinak je v pořádku
		S415_UNSUPPORTED_MEDIA_TYPE = '415', // nepodporovaný content-type
		S426_UPGRADE_REQUIRED = '426', // nepodporovaná verze API

		S500_INTERNAL_SERVER_ERROR = '500', // chyba serveru
		S501_NOT_IMPLEMENTED = '501', // není implementováno
		S503_SERVICE_UNAVAILABLE = '503'; // momentálně nedostupné


	/** @var int */
	private $responseCode;


	/**
	 * @param array|\stdClass $payload
	 * @param null $responseCode
	 */
	public function __construct($payload, $responseCode)
	{
		parent::__construct($payload);

		if (is_string($responseCode))
		{
			$responseCode = (int) substr($responseCode, 0, 3);
		}
		$this->responseCode = $responseCode;
	}

	/**
	 * @return int
	 */
	public function getResponseCode()
	{
		return $this->responseCode;
	}

	/**
	 * Je úspěšná?
	 *
	 * @return bool
	 */
	public function isSuccess()
	{
		return substr($this->responseCode, 0, 1) === '2';
	}

	/**
	 * Odesílá response
	 *
	 * @param IRequest
	 * @param IResponse
	 */
	public function send(IRequest $httpRequest, IResponse $httpResponse)
	{
		$httpResponse->setCode($this->responseCode);

		parent::send($httpRequest, $httpResponse);
	}

}
