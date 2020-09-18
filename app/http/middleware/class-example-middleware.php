<?php
/**
 * Example_Middleware class file.
 *
 * @package App
 */

namespace App\Http\Middleware;

use Closure;

/**
 * Example Middleware
 */
class Example_Middleware {
	/**
	 * Handle the request and modify the response.
	 *
	 * @param \Mantle\Framework\Http\Request|\WP_REST_Request $request Request object.
	 * @param Closure                                         $next Callback to continue.
	 * @return mixed
	 */
	public function handle( $request, Closure $next ) {
		// Perform some action...

		return $next( $request );
	}
}
