<?php
/**
 * Asset_Service_Provider class file.
 *
 * @package Mantle
 */

namespace App\Providers;

use Mantle\Assets\Asset_Service_Provider as Service_Provider;
use Mantle\Facade\Asset;

/**
 * Asset Service Provider
 */
class Asset_Service_Provider extends Service_Provider {
	/**
	 * Boot the service provider.
	 *
	 * Register any asset conditions that need to be loaded.
	 *
	 * @return void
	 */
	public function boot() {
		/*
		|--------------------------------------------------------------------------
		| Enqueue Assets
		|--------------------------------------------------------------------------
		|
		| Enqueue a raw asset using the asset() helper:
		|
		| 	 asset()->script( 'example-entry' )->async()->src( 'https://example.org/script.js' );
		| 	 asset()->style( 'example-entry' )->condition( 'single' )->src( 'https://example.org/style.css' );
		|
		| Enqueue an asset from the asset map using the asset_map() helper:
		|
		|     asset_map()->enqueue( 'example-entry.js' )->async();
		|     asset_map()->enqueue( 'example-entry.css' )->condition( 'single' );
		|
		| Retrieve information about an asset from the asset map using the asset_map() helper:
		|
		|     asset_map()->path( 'example-entry.js' );
		|     asset_map()->hash( 'example-entry.js' );
		|
		| Get cookin'!
		|
		*/
	}

	/**
	 * Filter the asset conditions for the site.
	 *
	 * @param array $conditions Conditions to filter.
	 * @return array
	 */
	public function on_am_asset_conditions( array $conditions ): array {
		// Perform any modifications here.

		return $conditions;
	}
}
