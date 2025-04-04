<?php

use Drupal\recipe\Services\RecipeServices;
use Drupal\Tests\UnitTestCase;

class RecipeServicesTest extends UnitTestCase {

  public function testAdd() {
    $sut = new RecipeServices();
    $this->assertEquals(5, $sut->add(2, 3));
  }

}
