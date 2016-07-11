<?php
/**
 * @file
 * Contains \Drupal\xio_documentation\Form\XioDocumentationConfigurationForm.
 */

namespace Drupal\xio_documentation\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures the documentation settings.
 */
class XioDocumentationConfigurationForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'xio_documentation_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'xio_documentation.settings',
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('xio_documentation.settings');

    $intros = $config->get('intros');
    if (empty($intros)) {
      $intros = array();
    }
    $intros['$$new$$'] = array(
      'path' => '',
      'intro' => '',
    );
    $form['intros'] = array(
      '#type' => 'fieldset',
      '#title' => t('Intros'),
      '#tree' => TRUE,
    );
    $i = -1;
    foreach ($intros as $key => $intro) {
      $is_new = empty($intro['path']);
      $i++;

      $form['intros'][$key] = array(
        '#type' => 'details',
        '#title' => $is_new ? t('Add new') : $intro['path'],
        '#open' => $is_new ? TRUE : FALSE,
        '#tree' => TRUE,
      );

      $form['intros'][$key]['path'] = array(
        '#type' => 'textfield',
        '#title' => t('Path'),
        '#required' => $is_new ? FALSE : TRUE,
        '#default_value' => $intro['path'],
      );

      $form['intros'][$key]['intro'] = array(
        '#type' => 'textarea',
        '#title' => t('Intro'),
        '#default_value' => $intro['intro'],
      );
      if (!$is_new) {
        $form['intros'][$key]['delete'] = array(
          '#type' => 'checkbox',
          '#title' => t('Delete'),
        );
      }
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_values = $form_state->getValues();
    $intros = array();
    foreach ($form_values['intros'] as $key => $intro) {
      if ($key == '$$new$$' && empty($intro['path'])) {
        continue;
      }
      // Remove the entries that have 'Delete' checked.
      if (empty($intro['delete'])) {
        $intro['path'] = '/' . trim($intro['path'], ' /');
        unset($intro['delete']);
        $intros[$intro['path']] = $intro;
      }
    }

    $this->config('xio_documentation.settings')
      ->set('intros', $intros)
      ->save();
  }

}
