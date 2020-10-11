# Installation

- [Installation](#installation)
	- [Requirements](#requirements)
	- [Installing a new Mantle Site](#installing-a-new-mantle-site)
		- [Via Mantle Installer](#via-mantle-installer)
		- [Via Composer Create-Project](#via-composer-create-project)
	- [Configuration](#configuration)

## Requirements
Mantle has two system requirements to run: PHP to be at least running 7.3 and
WordPress to be at least 5.4.

In the future, unit tests will be run using SQLite instead of MySQL. To support
SQLite, PHP needs to have the PDO extension with the SQlite driver installed. In
the event those requirements aren't met, Mantle will fall back to MySQL.

## Installing a new Mantle Site

Mantle sites should live in `wp-content/plugins/{site-slug}/` inside a WordPress
project.

### Via Mantle Installer

Download the Mantle installer using [Composer](https://getcomposer.org/).

```bash
composer global require alleyinteractive/mantle-installer
```

Once installed the `mantle new` command will create a fresh Mantle installation
wherever you specify. It can also install WordPress for you or install Mantle
into an existing WordPress installation.

```bash
mantle new my-site
```

### Via Composer Create-Project

You can install a Mantle site using Composer, replacing `my-site` with your site's slug.

```bash
cd wp-content/plugins/
composer create-project alleyinteractive/mantle-site my-site \
--repository="{\"url\": \"https://github.com/alleyinteractive/mantle-site.git\", \"type\": \"vcs\"}" \
--remove-vcs --stability=dev --no-cache --no-interaction
```

_Note: In the future, we'll create a command to simplify this, so creating a site will be as
easy as `mantle new <site>`._

## Configuration
Mantle should be loaded through a `mu-plugin`, `client-mu-plugin`, or another
initialization script as a plugin. To ensure that all features work correctly,
Mantle should be loaded before the `muplugins_loaded` action is fired.
