<?php
/**
 * Database_Seeder class file.
 *
 * @package Mantle
 */

namespace App\Database\Seeds;

use Mantle\Database\Seeder;

/**
 * Application Seeder
 */
class Database_Seeder extends Seeder {
	/**
	 * Run the seeder.
	 */
	public function run() {
		dd('aad', \App\Models\Post::factory());
		// Call additional seeders...
	}
}
