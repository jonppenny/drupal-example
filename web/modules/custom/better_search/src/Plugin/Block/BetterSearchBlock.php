<?php

namespace Drupal\better_search\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Class BetterSearchBlock.
 *
 * @Block(
 *   id = "better_search_block",
 *   admin_label = @Translation("Better Search Block"),
 *   category = @Translation("Forms")
 * )
 *
 * @package Drupal\better_search\Plugin\Block
 */
class BetterSearchBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#cache'              => ['max-age' => 0],
      '#theme'              => 'better_search_block',
      '#better_search_form' => \Drupal::formBuilder()->getForm('\Drupal\better_search\Form\BetterSearchForm'),
      '#attached'           => [
        'drupalSettings' => [],
        'library'        => ['better_search/better_search'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge(): int {
    return 0;
  }

}
