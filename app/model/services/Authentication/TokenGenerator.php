<?php

namespace App\Authentication;

use Nette;


/**
 * Generates tokens
 *
 */
class TokenGenerator
{

	/** int */
	private $tokenLength;

	public function __construct($tokenLength)
	{
		$this->tokenLength = $tokenLength;

	}

	/**
	 * Generates random string to be used as a token
	 *
	 * @return string
	 */
	public function generateToken()
	{
		return Nette\Utils\Random::generate($this->tokenLength);
	}

}
