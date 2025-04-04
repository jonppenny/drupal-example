<?php

declare(strict_types=1);

namespace Drupal\recipe;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of recipe type entities.
 *
 * @see \Drupal\recipe\Entity\RecipeType
 */
final class RecipeTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render(): array {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No recipe types available. <a href=":link">Add recipe type</a>.',
      [':link' => Url::fromRoute('entity.recipe_type.add_form')->toString()],
    );

    return $build;
  }

}
