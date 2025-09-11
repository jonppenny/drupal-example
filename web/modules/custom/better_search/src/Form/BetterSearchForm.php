<?php

namespace Drupal\better_search\Form;

use Drupal;
use Drupal\Component\Utility\Html;
use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class BetterSearchForm extends FormBase {

  /**
   * Lang code.
   *
   * @var string
   */
  protected string $langCode;

  /**
   * SearchController constructor.
   */
  public function __construct() {
    $this->langCode = Drupal::languageManager()->getCurrentLanguage()->getId();
  }

  /**
   * @inheritdoc
   */
  public function getFormId(): string {
    return 'better_search_form';
  }

  /**
   * @inheritdoc
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $params = Drupal::request()->query->all();

    $search = '';

    if (array_key_exists('search_query', $params)) {
      $escape = Html::escape($params['search_query']);
      $search = Database::getConnection()->escapeLike($escape);
    }

    $form['search_query'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Search'),
      '#required'      => TRUE,
      '#default_value' => (array_key_exists('search_query', $params)) ? $search : '',
      '#attributes'    => [
        'id'          => 'better-search',
        'placeholder' => $this->t('Enter a search term...'),
        'class'       => ['form-control'],
        'aria-label'  => $this->t('Search'),
      ],
    ];

    $form['actions']['clear_form_link'] = [
      '#type'   => 'markup',
      '#markup' => '<a class="btn btn-link clear">' . $this->t('Clear') . '</a>',
    ];

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type'        => 'submit',
      '#value'       => $this->t('Search'),
      '#button_type' => 'primary',
      '#attributes'  => [
        'class' => ['btn', 'btn-primary'],
      ],
    ];

    return $form;
  }

  /**
   * @inheritdoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $query = [];

    if ($search_term = $form_state->getValue('search_query')) {
      $query['search_query'] = $search_term;
    }

    $url = Url::fromRoute(
      'better_search_result',
      [],
      [
        'query' => $query,
      ]
    );

    $form_state->setRedirectUrl($url);
  }

}
