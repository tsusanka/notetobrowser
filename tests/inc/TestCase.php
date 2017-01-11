<?php

namespace Tests;

use App;
use Nette;
use DibiConnection;


/**
 * Base class for all test cases
 *
 * @property-read App\RepositoryContainer $orm
 * @property-read DibiConnection $dibi
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{

	/** @var Nette\DI\Container */
	protected $context;

	/** @return Nette\DI\Container */
	public function getContext()
	{
		if ($this->context === NULL) {
			$this->context = $GLOBALS['container'];
		}
		return $this->context;
	}

	/** @return Ovozel\RepositoryContainer */
	public function getOrm()
	{
		return $this->getContext()->getService('orm');
	}

	/** @return DibiConnection */
	public function getDibi()
	{
		return $this->getContext()->getService('dibi.connection');
	}


	protected function setUp()
	{
		parent::setUp();
		$db = $this->getContext()->parameters['database']['database'];
		$this->getDibi()->query('USE %n', $db);
	}


	/**
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		parent::tearDown();
	}


	/**
	 * Vynucuje existenci @covers anotace při generování code coverage.
	 *
	 * @throws \Exception
	 * @return mixed
	 */
	protected function runTest()
	{
		if ($this->getTestResultObject()->getCollectCodeCoverageInformation())
		{
			$annotations = $this->getAnnotations();
			if (
				!isset($annotations['class']['covers']) && !isset($annotations['method']['covers'])
				&& !isset($annotations['class']['coversNothing']) && !isset($annotations['method']['coversNothing'])
			)
			{
				throw new \Exception('Chybí povinná @covers/@coversNothing anotace!');
			}
		}
		return parent::runTest();
	}


	/**
	 * Zkontroluje, že daný callback vyhodí danou vyjímku.
	 *
	 * <code>
	 *	$this->assertThrows(function () use ($object) {
	 *      $object->foo(NULL);
	 *  }, 'Tripilot\InvalidArgumentException', 'Service name must be a non-empty string, NULL given.');
	 * </code>
	 *
	 * @author Jan Tvrdík
	 * @param  callback
	 * @param  string      název výjimky (třeba Tripilot\InvalidStateException)
	 * @param  string|NULL text výjimky
	 * @param  string      informační hláška zobrazená při vyhození špatné výjimky
	 * @return void
	 */
	public static function assertThrows($callback, $exceptionName, $exceptionMessage = NULL, $message = '')
	{
		try
		{
			call_user_func($callback);
			self::fail("Expected $exceptionName.");
		}
		catch (\PHPUnit_Framework_AssertionFailedError $e)
		{
			throw $e;
		}
		catch (\Exception $e)
		{
			self::assertInstanceOf($exceptionName, $e, $message);
			if ($exceptionMessage)
			{
				self::assertSame($exceptionMessage, $e->getMessage(), $message);
			}
		}
	}

}
