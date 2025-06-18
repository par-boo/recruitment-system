<?php

namespace Drupal\custom_login\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class CustomLoginController extends ControllerBase

{

  protected $formBuilder;

  /**
   * Constructs a CustomLoginController object.
   *
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder service.
   */
  public function __construct(FormBuilderInterface $form_builder)
  {
    $this->formBuilder = $form_builder;

  }

  /**
   * Returns a custom login page.
   *
   * @return array
   *   A render array containing the login form.
   */
  public function customLoginPage()
  {
    $form = $this->formBuilder->getForm('Drupal\user\Form\UserLoginForm');

    return [
      '#theme' => 'custom_login_page',
      '#login_form' => $form,
      '#description' => $this->t('Please log in to access your account.'),
      '#cache' => [
        'max-age' => 0, // Don't cache for logged-in users
      ],
    ];


  }

  public static function access(AccountInterface $account) {
    return $account->isAnonymous()
      ? AccessResult::allowed()
      : AccessResult::forbidden();
  }
}
