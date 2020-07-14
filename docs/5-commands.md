Commands
========

## Introduction
Mantle provides a `wp-cli` integration to help make writing commands easier. This will guide you through creating a command and interacting with input.

## Writing Commands
Commands live in the `app/console` directory.

### Generating a Command
```bash
wp mantle make:command <name>
```

### Registering a Command
Commands can be added to the `app/console/class-kernel.php` file in your application.

```php
namespace App\Console;

use Mantle\Framework\Console\Kernel as Console_Kernel;

/**
 * Application Console Kernel
 */
class Kernel extends Console_Kernel {
	/**
	 * The commands provided by the application.
	 *
	 * @var array
	 */
	protected $commands = [
		Command_To_Register::class,
	];
}
```

### Command Structure
After generating a command, you should verify the `$name` and `$synopsis` properties which determine the name and arguments/flags for the command, respectively. The `$synopsis` property is the `wp-cli` definition of the command's arguments ([reference the `wp-cli` documentation](https://make.wordpress.org/cli/handbook/guides/commands-cookbook/)). The Mantle Service Container will automatically inject all dependencies that are type-hinted in the class. The following command would be registered to `wp mantle example_command`:

```php
namespace App\Console;

use Mantle\Framework\Console\Command;

/**
 * Example_Command Controller
 */
class Example_Command extends Command {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'example_command';

	/**
	 * Command Short Description.
	 *
	 * @var string
	 */
	protected $short_description = '';

	/**
	 * Command Description.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Command synopsis.
	 *
	 * Supports registering command arguments in a string or array format.
	 * For example:
	 *
	 *     <argument> --example-flag
	 *
	 * @var string|array
	 */
	protected $synopsis = '';

	/**
	 * Callback for the command.
	 *
	 * @param array $args Command Arguments.
	 * @param array $assoc_args Command flags.
	 */
	public function handle( array $args, array $assoc_args ) {
		// Write to the console.
		$this->log( 'Message to write.' );

		// Error to the console.
		$this->error( 'Error message but does not exit without the second argument being true' );

		// Ask for input.
		$question = $this->prompt( 'Ask a question?' );
		$password = $this->secret( 'Ask a super secret question?' );

		// Get an argument.
		$arg = $this->get_arg( 0, 'Default Value' );

		// Get a flag.
		$flag = $this->get_flag( 'flag-to-get', 'default-value' );
	}
}
```

