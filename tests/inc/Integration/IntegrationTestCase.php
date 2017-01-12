<?php

namespace Tests\Integration;

use Tests\TestsMigrationsLoader;
use Tests\TestCase;


abstract class IntegrationTestCase extends TestCase
{

	protected function setUp()
	{
		parent::setUp();

		$loader = new TestsMigrationsLoader($this->context);
		$loader->runMigrations();
	}

	protected function tearDown()
	{
		parent::tearDown();

		if (!$this->context->parameters['migrations']['enabled']) return;

		$dropDb = ($this->getStatus() === \PHPUnit_Runner_BaseTestRunner::STATUS_PASSED)
			? $this->context->parameters['migrations']['dropDatabaseOnSuccess']
			: $this->context->parameters['migrations']['dropDatabaseOnFailure'];

		if ($dropDb)
		{
			$this->getConnection()->query('DROP DATABASE IF EXISTS %table', $this->context->parameters['testDbName']);
			$this->context->parameters['testDbName'] = NULL;
		}
 	}

}
