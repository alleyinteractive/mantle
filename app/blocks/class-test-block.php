<?php
/**
 * Test Block
 * @package Mantle
 */

namespace App\Blocks;

use Mantle\Blocks\Block;
use Mantle\Contracts\Block as Block_Contract;

class Test_Block extends Block implements Block_Contract {

	protected string $namespace = 'app';

	protected string $name = 'test';

	public function register(){
		$this->editor_script = mix( 'blocks/test/index.js' );

		parent::register();
	}

}
