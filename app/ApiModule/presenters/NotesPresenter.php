<?php

namespace App\Api;

use App\InvalidArgumentException;
use App\Note;
use App\Orm;


class NotesPresenter extends BasePresenter
{

	/** @var Orm @inject */
	public $orm;


	public function actionAdd()
	{
		$user = $this->orm->users->getByHash($this->data->user);
		if (!$user) {
			throw new InvalidArgumentException('No such user with this hash.');
		}
		$note = new Note();
		$note->content = $this->data->content;
		$note->user = $user;

		$this->orm->persistAndFlush($note);

		$this->sendSuccessResponse(['id' => $note->id], ApiResponse::S201_CREATED);
	}

	public function actionDefault()
	{
		/** @var Note[] $notes */
		$notes = $this->orm->notes->findAll();
		$this->send($notes);
	}

	/**
	 * @param Note[] $notes
	 */
	private function send($notes)
	{
		$data = [];
		foreach ($notes as $note) {
			$data[] = $this->build($note);
		}
		$this->sendSuccessResponse($data);
	}

	/**
	 * Formats question into array
	 * @param  Note $note
	 * @return array
	 */
	private function build(Note $note)
	{
		return [
			'id' => $note->id,
			'content' => $note->content,
			'createdAt' => $note->createdAt,
		];
	}

}
