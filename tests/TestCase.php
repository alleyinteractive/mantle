<?php
/**
 * Test_Case Class
 *
 * @package App
 */

namespace App\Tests;

/**
 * Base Test Case that each Test Case should extend.
 */
abstract class TestCase extends \Mantle\Testing\Test_Case {
	use CreateApplication;
}
