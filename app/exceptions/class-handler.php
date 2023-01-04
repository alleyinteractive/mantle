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
	 * @var string[]
	 */
	protected $dont_report = [
		// ...
	];

	/**
	 * Report or log an exception.
	 *
	 * @param Throwable $exception Exception thrown.
	 */
	public function report( Throwable $exception ) {
		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Mantle\Http\Request $request Request object.
	 * @param  \Throwable           $exception Exception thrown.
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function render( $request, Throwable $exception ) {
		return parent::render( $request, $exception );
	}
}
