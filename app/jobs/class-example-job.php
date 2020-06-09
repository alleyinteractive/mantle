<?php
/**
 * Example_Job class file.
 *
 * @package Mantle
 */

namespace App\Jobs;

use Mantle\Framework\Contracts\Queue\Can_Queue;
use Mantle\Framework\Contracts\Queue\Job;
use Mantle\Framework\Queue\Dispatchable;
use Mantle\Framework\Queue\Queueable;

/**
 * Example Job that can be queued.
 */
class Example_Job implements Job, Can_Queue {
	use Queueable, Dispatchable;

	/**
	 * Handle the job.
	 */
	public function handle() {
		// Handle it here!
	}
}
