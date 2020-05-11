<?php
/**
 * Kernel class file.
 *
 * @package Mantle
 */

namespace App\Http;

use Mantle\Framework\Http\Kernel as Http_Kernel;

/**
 * Application HTTP Kernel
 *
 * Allows for customization of the HTTP Kernel on an application level.
 */
class Kernel extends Http_Kernel {
	/**
	 * HTTP Middleware
	 *
	 * @var array
	 */
	protected $middleware = [];
}
