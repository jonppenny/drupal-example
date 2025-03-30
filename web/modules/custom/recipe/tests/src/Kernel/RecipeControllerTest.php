<?php

namespace Drupal\recipe\Kernel;

use Drupal\KernelTests\KernelTestBase;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Prophecy\PhpUnit\ProphecyTrait;

class recipeControllerTest extends KernelTestBase {

  use ProphecyTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'system',
    'recipe',
  ];

  /**
   * The recipe services.
   *
   * @var \Drupal\recipe\Services\RecipeServices
   */
  protected mixed $recipeServices;

  /**
   * {@inheritdoc}
   * @throws \Exception
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(['system']);

    // Create a mock handler with a mock response.
    $mock = new MockHandler([
      new Response(200, [], json_encode([
        'recipes' => [
          [
            'id'   => 1,
            'name' => 'Classic Margherita Pizza',
          ],
          [
            'id'   => 2,
            'name' => 'Vegetarian Stir-Fry',
          ],
        ],
        'total'   => 50,
        'skip'    => 0,
        'limit'   => 30,
      ])),
    ]);

    // Create a handler stack with the mock handler.
    $handler = HandlerStack::create($mock);

    // Create a new client with the mocked handler.
    $client = new Client(['handler' => $handler]);

    // Mock the HTTP client factory service to return our mocked client.
    $client_factory = $this->prophesize('Drupal\Core\Http\ClientFactory');
    $client_factory->fromOptions(['timeout' => 15])->willReturn($client);

    // Replace the HTTP client factory service in the container.
    $this->container->set('http_client_factory', $client_factory->reveal());

    // Get the recipe services from the container.
    $this->recipeServices = $this->container->get('recipe.services');
  }

  /**
   * Tests the getRecipesFromSource method.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function testGetRecipesFromSource() {
    $result = $this->recipeServices->getRecipesFromSource();

    $this->assertIsArray($result);
    $this->assertArrayHasKey('recipes', $result);
    $this->assertEquals($result['total'], count($result['recipes']));
    $this->assertEquals(1, $result['recipes'][0]['id']);
    $this->assertEquals(2, $result['recipes'][1]['id']);
  }

}
