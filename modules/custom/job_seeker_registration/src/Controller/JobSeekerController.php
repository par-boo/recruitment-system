<?php

namespace Drupal\job_seeker_registration\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class JobSeekerController extends ControllerBase

{



  public static function access(AccountInterface $account) {
    return $account->isAnonymous()
      ? AccessResult::allowed()
      : AccessResult::forbidden();
  }
}
