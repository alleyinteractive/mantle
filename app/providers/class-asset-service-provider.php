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
		| Load the blocks included with the plugin.
		|--------------------------------------------------------------------------
		|
		| This will load the blocks included with the plugin and generated
		| with `npm run create-block`.
		|
		*/
		$this->load_blocks();

		/*
		|--------------------------------------------------------------------------
		| Enqueue Assets
		|--------------------------------------------------------------------------
		|
		| Enqueue an asset directly from the build/ folder (with any dependencies included)
		|
		|    asset()->script( '/app.js' )->async();
		|    asset()->style( '/article.css' )->condition( 'single' );
		|
		| Enqueue a raw asset using the asset() helper:
		|
		| 	 asset()->script( 'example-entry' )->async()->src( asset_loader( '/app.js' ) );
		| 	 asset()->style( 'example-entry' )->condition( 'single' )->src( asset_loader( '/app.css' ) );
		|
		| Enqueue an asset with dependencies from @wordpress/dependency-extraction-webpack-plugin:
		|
		| 	 asset()->script( 'example-block' )->src( asset_loader( '/example-block.js' ) )->dependencies( asset_loader()->dependencies( '/example-block.js' ) );
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
