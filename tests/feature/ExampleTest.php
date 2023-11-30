<?php
/**
 * Test_Case Class
 *
 * @package App
 */

namespace App\Tests\Feature;

use App\Tests\TestCase;

/**
 * Base Test Case that each Test Case should extend.
 */
class ExampleTest extends TestCase {
  public function test_example() {
    $this->assertTrue( true );
	}

	public function test_route() {
		$this->get( '/' )->assertOk();
	}
}
