<?php

namespace App;

use Nette\Utils\DateTime;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;


/**
 * @property int $id {primary}
 * @property string $hash
 * @property DateTime $registeredAt
 *
 * @property OneHasMany|Note[] $notes {1:m Note::$user, orderBy=[createdAt=DESC]}
 */
class User extends Entity
{

}
