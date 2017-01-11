<?php

namespace App;

use Nextras\Orm\Repository\Repository;


final class NotesRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [Note::class];
	}

}
