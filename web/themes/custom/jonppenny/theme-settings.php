<?php

declare(strict_types=1);

/**
 * @file
 * Theme settings form for JonPPenny theme.
 */

use Drupal\Core\Form\FormState;

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function jonppenny_form_system_theme_settings_alter(array &$form, FormState $form_state): void {

  $form['jonppenny'] = [
    '#type' => 'details',
    '#title' => t('JonPPenny'),
    '#open' => TRUE,
  ];

  $form['jonppenny']['example'] = [
    '#type' => 'textfield',
    '#title' => t('Example'),
    '#default_value' => theme_get_setting('example'),
  ];

}
