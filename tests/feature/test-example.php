<?php
/**
 * Test_Case Class
 *
 * @package App
 */

namespace App\Tests\Feature;

use App\Tests\Test_Case;

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
