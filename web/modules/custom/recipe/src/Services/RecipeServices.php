<?php

namespace Drupal\recipe\Services;

class RecipeServices {

  public function __construct() {}

  /**
   * @param int $a
   * @param int $b
   *
   * @return int
   */
  public function add(int $a, int $b): int {
    return $a + $b;
  }

  /**
   * @return array
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getRecipesFromSource(): array {
    try {
      $client   = \Drupal::httpClient();
      $request  = $client->get('https://dummyjson.com/recipes');
      $response = $request->getBody();
      return json_decode($response, TRUE);
    }
    catch (\Exception $e) {
      \Drupal::logger('recipe')
        ->error('Failed to fetch recipes: @error', ['@error' => $e->getMessage()]);
      return [];
    }
  }

}
