<?php

namespace App\Api;

use Nette\Utils\Strings;
use App\Note;


class NotesPresenter extends BasePresenter
{

	public function actionFetch()
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
			'title' => $note->title,
			'url' => $note->url,
		];
	}

}
