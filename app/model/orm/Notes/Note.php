<?php

namespace App;

use Nextras\Orm\Entity\Entity;
use Nette\Utils\DateTime;


/**
 * @property int $id {primary}
 * @property string $url
 * @property DateTime $createdAt
 */
class Note extends Entity
{

}
