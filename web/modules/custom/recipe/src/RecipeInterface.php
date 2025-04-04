<?php

declare(strict_types=1);

namespace Drupal\recipe;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a recipe entity type.
 */
interface RecipeInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
