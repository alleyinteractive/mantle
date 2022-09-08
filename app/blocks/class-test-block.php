<?php
/**
 * Test Block
 *
 * @package Mantle
 */

namespace App\Blocks;

use Mantle\Blocks\Block;
use Mantle\Contracts\Block as Block_Contract;

/**
 * An example of how to register a block with Mantle.
 */
class Test_Block extends Block implements Block_Contract {

	/**
	 * The name of the block.
	 *
	 * @var string
	 */
	protected string $name = 'test';

	/**
	 * The namespace of the block.
	 *
	 * @var string
	 */
	protected string $namespace = 'app';

	/**
	 * Executed by the Block Service Provider to handle registering the block
	 * with Mantle and WordPress.
	 *
	 * @return void
	 */
	public function register(): void {
		$this->editor_script = mix( 'blocks/test/index.js' );

		parent::register();
	}

}
