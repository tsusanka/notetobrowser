<?php

namespace App;

use Nextras\Orm\Entity\Entity;
use Nette\Utils\DateTime;


/**
 * @property int $id {primary}
 * @property string $content
 * @property DateTime $createdAt
 *
 * @property User $user {m:1 User::$notes}
 */
class Note extends Entity
{

}
