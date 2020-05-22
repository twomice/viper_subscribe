<?php

namespace Drupal\viper_subscribe\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

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

    $form['digest_mode'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Digest Mode'),
      '#default_value' => $config->get('viper_subscribe.digest_mode'),
      '#description' => $this->t('Turn on Digest Mode?'),
    );

    $form['digest_interval'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Digest Type'),
      '#default_value' => $config->get('viper_subscribe.digest_interval'),
      '#description' => $this->t('Machine Name of Digest Type to use, from <a href=":url">Message: Digest intervals</a>',
        [
          ':url' => Url::fromRoute('entity.message_digest_interval.collection')->toString(),
        ]
      ),
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
    $config->set('viper_subscribe.digest_mode', $form_state->getValue('digest_mode'));
    $config->set('viper_subscribe.digest_type', $form_state->getValue('digest_type'));
    $config->set('viper_subscribe.digest_interval', $form_state->getValue('digest_interval'));
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
