<?php
namespace App\Jobs;

use Mantle\Framework\Contracts\Queue\Can_Queue;
use Mantle\Framework\Queue\Dispatchable;
use Mantle\Framework\Queue\Queueable;

class Example_Job implements Can_Queue {
	use Dispatchable, Queueable;

	protected $post;
	public function __construct( $post ) {
		$this->post = $post;
	}

	public function handle() {
		var_dump('HANDLE', $this->post);
	}
}
