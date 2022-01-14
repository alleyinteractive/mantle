<?php
/**
 * Event_Service_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Framework\Providers\Event_Service_Provider as Service_Provider;
use Mantle\Facade\Event;

/**
 * Event Service Provider
 */
class Event_Service_Provider extends Service_Provider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		/**
		 * Listen to specific WordPress or Mantle Events.
		 *
		 * 'init' => [
		 *   \App\Listeners\On_Boot::class,
		 * ],
		 *
		 * Example_Event::class => [
		 *   \App\Listeners\Example_Listener::class,
		 * ],
		 */
	];

	/**
	 * Register any other events for your application.
	 *
	 * @return void
	 */
	public function boot() {
		// ...
	}

	/**
	 * Flag if Mantle should discover events automatically.
	 * If removed, event discovery will be disabled.
	 *
	 * @return bool
	 */
	public function should_discover_events(): bool {
		return true;
	}
}
