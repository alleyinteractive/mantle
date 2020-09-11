<?php
/**
 * Test_Case Class
 *
 * @package Mantle
 */

namespace Tests;

/**
 * Base Test Case that each Test Case should extend.
 */
abstract class Test_Case extends \Mantle\Framework\Testing\Test_Case {
	use Create_Application;
}
