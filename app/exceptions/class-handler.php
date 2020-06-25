<?php

namespace App\Exceptions;

use Mantle\Framework\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dont_report = [];

	/**
	 * Report or log an exception.
	 *
	 * @param Throwable $exception
	 * @return void
	 *
	 * @throws Exception
	 */
	public function report( Throwable $exception ) {
		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Mantle\Framework\Http\Request $request
	 * @param  \Throwable               $exception
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 * @throws \Throwable
	 */
	public function render( $request, Throwable $exception ) {
		return parent::render( $request, $exception );
	}
}
