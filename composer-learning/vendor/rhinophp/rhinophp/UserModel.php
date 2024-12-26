<?php

/**
 */

namespace rhinophp\rhinophp;

use rhinophp\rhinophp\db\DbModel;

/**
 * Class UserModel
 *
 */
abstract class UserModel extends DbModel
{
  abstract public function getDisplayName(): string;
}