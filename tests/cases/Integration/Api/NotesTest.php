<?php

namespace Tests\Integration\Api;

/**
 * @covers \App\Api\NotesPresenter
 */
class NotesTest extends ApiTestCase
{

	public function testDefault()
	{
		$response = $this->sendApiRequest('GET', 'notes', NULL);
		$this->assertSuccessResponse($response);
		$this->assertSame($response->body[0]->content, 'eur');
		$this->assertSame(count($response->body), 5);
	}

}
