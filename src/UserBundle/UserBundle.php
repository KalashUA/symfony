<?php
/**
 * Created by PhpStorm.
 * User: aleks
 * Date: 29.04.16
 * Time: 10:42
 */

namespace UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserBundle extends Bundle {
  public function getParent() {
    return 'FOSUserBundle';
  }
}