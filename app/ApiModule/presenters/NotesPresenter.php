<?php

namespace App\Api;

use App\Note;
use App\Orm;


class NotesPresenter extends BasePresenter
{

	/** @var Orm @inject */
	public $orm;


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
