# Tutorial

[[toc]]

## Introduction

This quick-start guide aims to provide a basic introduction to Mantle and its
features. This is a great starting point if you are brand new to Mantle and even
WordPress alike.

## Installation

::: details
This guide assumes that you are running WordPress in a Vagrant or similar local
PHP environment such as [VVV](https://varyingvagrantvagrants.org/).
:::

Download the Mantle installer using [Composer](https://getcomposer.org/).

::: tip
The `composer global config` will be unnecessary once Mantle is open-sourced.
:::

```bash
composer global config repositories.mantle-installer git git@github.com:alleyinteractive/mantle-installer.git
composer global require alleyinteractive/mantle-installer
```

Once downloaded, change your directory to a folder that is shared with your
Vagrant machine. For example if `~/web` is shared with `/var/www` on my machine,
switch to `~/web`. Run the installer:

```bash
mantle new my-project -i
```

Once that is complete you will have WordPress installed at `~/web/my-project`.
Open up your browser and navigate to `my-project.test` (or whatever web host you
setup) to complete installation.

## Open Your Editor

Once installation is complete you can open up your editor. Open the folder your
just installed `~/web/my-project` and navigate to the Mantle plugin in
`wp-content/plugins/my-project`.

## Create a Post Type Model

Scaffold a new `project` post type using [`wp-cli`](https://wp-cli.org/).

```bash
wp mantle make:model Project --model_type=post --registrable
```

The console command should have succeeded and told you to include the model in
your configuration file. Go ahead and open up `config/models.php` inside of your
Mantle plugin and add `App\Models\project::class` to the array there. It should
look like this:

```php
<?php
/**
 * Model Configuration
 *
 * @package Mantle
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Application Models
	|--------------------------------------------------------------------------
	|
	| This is an array of models that should be registered for the application.
	| The models can be post types, terms, etc.
	*/
	'register' => [
		App\Models\Project::class
	],
];
```

## Creating a Factory

Instead of having to open up `wp-admin` and create data yourself, we can use
[Mantle's Factories](../3-models/4-model-factory.md) to create data for us. Open
up your terminal and use the `make:factory` command:

```bash
wp mantle make:factory Project --model_type=post
```

That command will create a factory for your project in
`database/factories/project-factory.php`. Open that file up and modify
the factory's definition for the project post type to include some additional
meta data.

::: tip
Factories can use the [Faker](https://github.com/fzaninotto/Faker) package to
create "real" data quickly.
:::

```php
<?php
/**
 * Project Factory
 *
 * @package Mantle
 */

// phpcs:disable Squiz.Commenting.FunctionComment.MissingParamComment

namespace App\Factory;

use Faker\Generator as Faker;
use Mantle\Framework\Support\Str;
use App\Models\Project;

/**
 * Factory definition.
 *
 * @var \Mantle\Framework\Database\Factory\Factory $factory
 */
$factory->define(
	Project::class, // phpcs:ignore
	function ( Faker $faker ) {
		return [
			'post_title'   => $faker->sentence,
			'post_content' => $faker->paragraph,
			'post_status'  => 'publish',
			'post_type'    => 'project',

			'meta' 				=> [
				'project_owner' => $faker->name,
				'project_email' => $faker->email,
			],
		];
	}
);

```

## Seeding Some Data

By default Mantle includes a seeder in every project in the
`wp-content/plugins/my-project/database/seeds/class-database-seeder.php` file.
Let's open that file up and include our new factory.

```php
<?php
/**
 * Database_Seeder class file.
 *
 * @package Mantle
 */

namespace App\Database\Seeds;

use App\Models\Project;
use Mantle\Framework\Database\Seeder;
use function Mantle\Framework\Helpers\factory;

/**
 * Application Seeder
 */
class Database_Seeder extends Seeder {
	/**
	 * Run the seeder.
	 */
	public function run() {
		factory( Project::class, 10 )->create();
	}
}
```

With that added, lets run the database seeder. Inside of your console you can
run:

```bash
wp mantle db:seed
```

If you open up your WordPress admin and navigate to the Projects post type
you'll now see 10 new project posts.

## Creating a Route

Next, we're ready to add a route to view that new post type. Web routes are
stored in `routes/web.php` by default. For our purposes, we'll create a new
route to view the `Project` model and wrap it in the `web` middleware.

Inside of `routes/web.php`, create two routes: one to list projects and another
to view a specific project.

::: tip
The second route uses PHP type-hinting to automatically resolve the model
instance with [implicit model binding](../2-basics/0-requests.md#implicit-binding).
:::

```php
Route::get( '/projects', function() {
	return response()->view( 'list', [ 'projects' => Project::all() ] );
} );


Route::get( '/project/{project}', function( Project $project ) {
	return response()->view(
		'single',
		[
			'title' => $project->title,
			'owner' => $project->meta->project_owner,
			'email' => $project->meta->project_email,
		]
	)
} );

```

## Creating a View

Mantle supports using Blade templates as well as normal PHP templates in your
application. Create a new view at `plugins/my-project/views/single.blade.php`:

```php
<h1>{{$title}}</h1>
<p>Project Owner: {{$owner}}</p>
<p>Project Email: {{$email}}</p>
```

Additionally create a normal PHP template at
`wp-content/plugins/my-project/views/list.php`:

```php
<ul>
	<?php foreach ( mantle_get_var( 'projects' ) as $project ) : ?>
		<li>
			<a href="<?php echo esc_url( home_url( '/project/' . $project->id ) ); ?>">
				<?php echo esc_html( $project->title ); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

```

You are now able to open up you browser and go to `/projects` on your project's
website (`https://my-project.test/projects` for example).
