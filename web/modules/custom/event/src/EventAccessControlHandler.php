<?php

declare(strict_types=1);

namespace Drupal\event;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the event entity type.
 *
 * phpcs:disable Drupal.Arrays.Array.LongLineDeclaration
 *
 * @see https://www.drupal.org/project/coder/issues/3185082
 */
final class EventAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult {
    if ($account->hasPermission($this->entityType->getAdminPermission())) {
      return AccessResult::allowed()->cachePerPermissions();
    }

    return match($operation) {
      'view' => AccessResult::allowedIfHasPermission($account, 'view event'),
      'update' => AccessResult::allowedIfHasPermission($account, 'edit event'),
      'delete' => AccessResult::allowedIfHasPermission($account, 'delete event'),
      'delete revision' => AccessResult::allowedIfHasPermission($account, 'delete event revision'),
      'view all revisions', 'view revision' => AccessResult::allowedIfHasPermissions($account, ['view event revision', 'view event']),
      'revert' => AccessResult::allowedIfHasPermissions($account, ['revert event revision', 'edit event']),
      default => AccessResult::neutral(),
    };
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL): AccessResult {
    return AccessResult::allowedIfHasPermissions($account, ['create event', 'administer event'], 'OR');
  }

}
