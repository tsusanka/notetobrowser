<?php

namespace App;

use Nextras\Orm\Repository\Repository;


final class UsersRepository extends Repository
{

	static function getEntityClassNames()
	{
		return [User::class];
	}

	/**
	 * @param $hash
	 * @return User|NULL
	 */
	public function getByHash($hash)
	{
		return $this->getBy([
			'hash' => $hash,
		]);
	}

}
