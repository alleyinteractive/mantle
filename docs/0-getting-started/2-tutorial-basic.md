# Basic Tutorial

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
