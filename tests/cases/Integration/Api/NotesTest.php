<?php

namespace Tests\Integration\Api;

use App\Api\ApiResponse;

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

	public function testAdd()
	{
		$response = $this->sendApiRequest('POST', 'notes', [
			'content' => 'Lorem ipsum',
			'user' => '98a3818f67fc20fe9af17bebf32ce482e43a32ab3c979e48849efcad8b69ac13',
		]);
		$this->assertSuccessResponse($response, ApiResponse::S201_CREATED);

		$id = $response->body->id;
		$this->assertTrue(is_int($id));
	}

}
