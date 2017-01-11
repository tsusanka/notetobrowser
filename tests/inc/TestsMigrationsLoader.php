<?php

namespace Tests;

use Nette\DI\Container;
use Nette\Object;
use Nextras\Migrations\Bridges\Dibi\DibiAdapter;
use Nextras\Migrations\Drivers\MySqlDriver;
use Nextras\Migrations\Engine\Runner;
use Nextras\Migrations\Entities\Group;
use Nextras\Migrations\Extensions\SqlHandler;
use Nextras\Migrations\IDriver;
use Nextras\Migrations\Printers\DevNull;


/**
 * Creates DB and fills with dummy data.
 */
class TestsMigrationsLoader extends Object
{

	/** @var Container */
	private $context;

	/** @var IDriver */
	private $driver;


	public function __construct(Container $context)
	{
		$this->context = $context;
	}


	protected function createDb()
	{
		if (!$this->context->parameters['migrations']['enabled']) return NULL;

		$connection = $this->context->getService('dibi.connection');
		$dbNamePrefix = $this->context->parameters['testDbPrefix'] . date('Ymd_His') . '_';
		$i = 1;
		do
		{
			$dbName = $dbNamePrefix . $i;
			$i++;
		}
		while (
		$connection->query('SHOW DATABASES WHERE %n', 'Database', ' = %s', $dbName)
			->count()
		);
		$connection->query('CREATE DATABASE %n', $dbName);
		$connection->query('USE %n', $dbName);

		$this->context->parameters['testDbName'] = $dbName;
	}

	/**
	 * Vytvoří DB a naplní testovacími daty.
	 */
	public function runMigrations()
	{
		$this->createDb();

		$dibiAdapter = new DibiAdapter($this->context->getService('dibi.connection'));
		$this->driver = new MySqlDriver($dibiAdapter);

		$runner = new Runner($this->driver, new DevNull());

		foreach ($this->getGroups(TRUE) as $group) {
			$runner->addGroup($group);
		}

		foreach ($this->getExtensionHandlers() as $ext => $handler) {
			$runner->addExtensionHandler($ext, $handler);
		}

		$runner->run(Runner::MODE_RESET);
	}


	/**
	 * @param  bool $withDummy
	 * @return Group[]
	 */
	protected function getGroups($withDummy)
	{
		$dir = $this->context->parameters['migrationsPath'];

		$structures = new Group();
		$structures->enabled = TRUE;
		$structures->name = 'structures';
		$structures->directory = $dir . '/structures';
		$structures->dependencies = [];

		$basicData = new Group();
		$basicData->enabled = TRUE;
		$basicData->name = 'basic-data';
		$basicData->directory = $dir . '/basic-data';
		$basicData->dependencies = ['structures'];

		$dummyData = new Group();
		$dummyData->enabled = $withDummy;
		$dummyData->name = 'dummy-data';
		$dummyData->directory = $dir . '/dummy-data';
		$dummyData->dependencies = ['structures', 'basic-data'];

		return [$structures, $basicData, $dummyData];
	}


	/**
	 * @return array (extension => IExtensionHandler)
	 */
	protected function getExtensionHandlers()
	{
		return [
			'sql' => new SqlHandler($this->driver),
		];
	}
}
