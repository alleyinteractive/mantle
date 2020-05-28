<?php
namespace App\Jobs;

use Mantle\Framework\Contracts\Queue\Can_Queue;
use Mantle\Framework\Queue\Dispatchable;

class Example_Job implements Can_Queue {
	use Dispatchable;

	public function handle() {
		//
	}
}
