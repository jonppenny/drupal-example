<?php

namespace Drupal\better_search\Controller;

use Drupal;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Exception;

/**
 * BetterSearchController
 */
class BetterSearchController extends ControllerBase {

  protected string $langCode;

  public function __construct() {
    $this->langCode = Drupal::languageManager()->getCurrentLanguage()->getId();
  }

  /**
   * @return array
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  public function index(): array {
    $params = Drupal::request()->query->all();

    $build[] = [
      '#form'   => $this->formBuilder()->getForm('\Drupal\better_search\Form\BetterSearchForm'),
      '#params' => $params,
      '#rows'   => $this->getSearchResults($params),
      '#theme'  => 'better_search_result',
    ];

    $build[] = [
      '#type' => 'pager',
    ];

    return $build;
  }

  /**
   * @param array $params
   *
   * @return array
   * @throws InvalidPluginDefinitionException
   * @throws PluginNotFoundException
   */
  protected function getSearchResults(array $params): array {
    $entityTypeManager = Drupal::entityTypeManager();
    $entityTypes = $this->getAllEntityTypes($entityTypeManager);
    $results = [];

    $string = $params['search_query'] ?? NULL;

    if (!$string) {
      return $results;
    }

    foreach ($entityTypes as $entityTypeId => $entityType) {
      try {
        $storage = $entityTypeManager->getStorage($entityTypeId);
        $query = $storage->getQuery()->accessCheck();

        $isConfigEntity = $entityType->entityClassImplements('\Drupal\Core\Config\Entity\ConfigEntityInterface');

        if ($entityType->hasKey('label')) {
          $labelField = $entityType->getKey('label');

          if (!$isConfigEntity) {
            $query->condition($labelField, '%' . $string . '%', 'LIKE');
          }
          $entity_ids = $query->execute();
        }
        elseif ($entityType->hasKey('name')) {
          $labelField = $entityType->getKey('name');

          if (!$isConfigEntity) {
            $query->condition($labelField, '%' . $string . '%', 'LIKE');
          }
          $entity_ids = $query->execute();
        }
        else {
          continue;
        }

        if (empty($entity_ids)) {
          continue;
        }

        $entities = $storage->loadMultiple($entity_ids);

        if ($isConfigEntity) {
          $entities = array_filter($entities, function($entity) use ($string) {
            $label = strtolower($entity->label());
            return str_contains($label, strtolower($string));
          });
        }

        foreach ($entities as $entity) {
          $results[] = [
            'entity_type' => $entityTypeId,
            'entity_id'   => $entity->id(),
            'label'       => $entity->label(),
          ];
        }
      }
      catch (Exception $e) {
        Drupal::logger('better_search')
          ->error('Error searching @entity_type: @message', [
            '@entity_type' => $entityTypeId,
            '@message'     => $e->getMessage(),
          ]);
      }
    }

    return $results;
  }

  /**
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *
   * @return array
   */
  protected function getAllEntityTypes(EntityTypeManagerInterface $entityTypeManager): array {
    return $entityTypeManager->getDefinitions();
  }

}
