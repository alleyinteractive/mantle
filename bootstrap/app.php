<?php
/**
 * Mantle Application
 *
 * @package Mantle
 */

use Mantle\Framework\Bootloader;

return Bootloader::create()
	->with_kernels(
		console: App\Console\Kernel::class,
		http: App\Http\Kernel::class,
	)
	->with_exception_handler( App\Exceptions\Handler::class )
	->with_routing(
		web: __DIR__ . '/../routes/web.php',
		rest_api: __DIR__ . '/../routes/rest-api.php',
		pass_through: true,
	);
