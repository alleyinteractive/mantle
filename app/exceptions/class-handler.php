<?php
/**
 * Handler class file.
 *
 * @package Mantle
 */

namespace App\Exceptions;

use Mantle\Framework\Exceptions\Handler as Base_Handler;
use Throwable;

/**
 * Application Error Handler
 */
class Handler extends Base_Handler {

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array<int, class-string<\Throwable>>
	 */
	protected $dont_report = [
		// ...
	];

	/**
	 * Report or log an exception.
	 *
	 * @param Throwable $exception Exception thrown.
	 */
	public function report( Throwable $exception ): void {
		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Mantle\Http\Request $request Request object.
	 * @param  \Throwable           $exception Exception thrown.
	 * @return mixed
	 */
	public function render( $request, Throwable $exception ): mixed {
		return parent::render( $request, $exception );
	}
}
