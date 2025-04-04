<?php

namespace Drupal\recipe\Controller;

use Drupal\Core\Controller\ControllerBase;

class RecipeController extends ControllerBase {

  /**
   * @var string
   */
  protected string $languageCode;

  /**
   * @var string
   */
  protected string $currentUserId;

  /**
   * RecipeController constructor.
   *
   */
  public function __construct() {
    $this->languageCode  = \Drupal::languageManager()
      ->getCurrentLanguage()
      ->getId();
    $this->currentUserId = \Drupal::currentUser()->id();
  }

  /**
   * @return array
   */
  public function index(): array {
    return [
      '#markup' => 'Hello, World!',
    ];
  }

  /**
   * @return array
   */
  public function show(): array {
    return [
      '#markup' => 'Hello, World!',
    ];
  }

}
