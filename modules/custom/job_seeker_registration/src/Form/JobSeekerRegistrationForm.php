<?php

namespace Drupal\job_seeker_registration\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class JobSeekerRegistrationForm extends FormBase {

  public function getFormId() {
    return 'job_seeker_register_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#required' => TRUE,
    ];
    $form['mail'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    ];
    $form['pass'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
    ];
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $user = User::create([
      'name' => $form_state->getValue('name'),
      'mail' => $form_state->getValue('mail'),
      'pass' => $form_state->getValue('pass'),
      'status' => 1,
    ]);
    $user->addRole('job_seeker');
    $user->save();

    user_login_finalize($user);
    $form_state->setRedirect('<front>');

    \Drupal::messenger()->addMessage($this->t('Welcome, @name!', ['@name' => $user->getDisplayName()]));  }
}
