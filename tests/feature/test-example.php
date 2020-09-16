<?php
/**
 * Test_Case Class
 *
 * @package Mantle
 */

namespace Tests\Feature;

use Mantle\Framework\Facade\Route;
use Tests\Test_Case;

/**
 * Base Test Case that each Test Case should extend.
 */
class Test_Example extends Test_Case {
  public function test_example() {
    $this->assertTrue( true );
	}

	public function test_route() {
		$this->get( '/' )->assertOk();
	}
}
