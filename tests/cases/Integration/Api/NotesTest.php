<?php

namespace Tests\Integration\Api;

/**
 * @covers \App\Api\NotesPresenter
 */
class NotesTest extends ApiTestCase
{

	public function testFetch()
	{
		$response = $this->sendApiRequest('GET', 'notes/fetch', NULL);
		$this->assertSuccessResponse($response);
		$this->assertSame(count($response->body), 5);
	}

}
