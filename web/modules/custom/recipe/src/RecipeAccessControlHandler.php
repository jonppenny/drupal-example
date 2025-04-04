<?php

declare(strict_types=1);

namespace Drupal\recipe;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the recipe entity type.
 *
 * phpcs:disable Drupal.Arrays.Array.LongLineDeclaration
 *
 * @see https://www.drupal.org/project/coder/issues/3185082
 */
final class RecipeAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult {
    if ($account->hasPermission($this->entityType->getAdminPermission())) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    return match($operation) {
      'view' => AccessResult::allowedIfHasPermission($account, 'view recipe'),
      'update' => AccessResult::allowedIfHasPermission($account, 'edit recipe'),
      'delete' => AccessResult::allowedIfHasPermission($account, 'delete recipe'),
      'delete revision' => AccessResult::allowedIfHasPermission($account, 'delete recipe revision'),
      'view all revisions', 'view revision' => AccessResult::allowedIfHasPermissions($account, ['view recipe revision', 'view recipe']),
      'revert' => AccessResult::allowedIfHasPermissions($account, ['revert recipe revision', 'edit recipe']),
      default => AccessResult::neutral(),
    };
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResult {
    return AccessResult::allowedIfHasPermissions($account, ['create recipe', 'administer recipe types'], 'OR');
  }

}
