<?php

namespace Drupal\custom_login\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\UserAuthInterface;

class CustomLoginForm extends FormBase {

  /**
   * @var \Drupal\user\UserAuthInterface
   */
  protected $userAuth;

  public function __construct(UserAuthInterface $userAuth) {
    $this->userAuth = $userAuth;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.auth')
    );
  }

  public function getFormId() {
    return 'custom_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $pass = $form_state->getValue('pass');

    $uid = $this->userAuth->authenticate($name, $pass);

    if ($uid) {
      $user = User::load($uid);
      user_login_finalize($user);
      $this->messenger()->addStatus($this->t('Successfully logged in.'));
      $form_state->setRedirect('<front>');
    } else {
      $this->messenger()->addError($this->t('Invalid login credentials.'));
    }
  }
}
