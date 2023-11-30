<?php
/**
 * Error Template: Generic
 * Props to Laravel for a great error template.
 *
 * phpcs:disable WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
 *
 * @package Mantle
 */

$exception = mantle_get_var( 'exception' );
$exception = $exception instanceof Throwable ? $exception->getMessage() : __( 'An error has occurred.', 'mantle' );
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php esc_html_e( 'Site Error', 'mantle' ); ?></title>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

		<!-- Styles -->
		<style>
			html, body {
				background-color: #fff;
				color: #636b6f;
				font-family: 'Nunito', sans-serif;
				font-weight: 100;
				height: 100vh;
				margin: 0;
			}

			.full-height {
				height: 100vh;
			}

			.flex-center {
				align-items: center;
				display: flex;
				justify-content: center;
			}

			.position-ref {
				position: relative;
			}

			.code {
				border-right: 2px solid;
				font-size: 26px;
				padding: 0 15px 0 15px;
				text-align: center;
			}

			.message {
				font-size: 18px;
				text-align: center;
			}
		</style>
	</head>
	<body>
		<div class="flex-center position-ref full-height">
			<div class="code">
				<?php echo esc_html( mantle_get_var( 'code' ) ); ?>
			</div>

			<div class="message" style="padding: 10px;">
				<?php echo esc_html( $exception ); ?>
			</div>
		</div>
	</body>
</html>
