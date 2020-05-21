<?php

namespace Drupal\viper_subscribe\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ViperSubscribeSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'vipersettings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('viper_subscribe.settings');

    $form['autosubscribe'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Autosubscribe to new content'),
      '#default_value' => $config->get('viper_subscribe.autosubscribe'),
      '#description' => $this->t('Autosubscribe all users to new content?'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('viper_subscribe.settings');
    $config->set('viper_subscribe.autosubscribe', $form_state->getValue('autosubscribe'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'viper_subscribe.settings',
    ];
  }

}
