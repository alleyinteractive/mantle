# Installation

- [Installation](#installation)
	- [Requirements](#requirements)
	- [Installing a new Mantle Site](#installing-a-new-mantle-site)
	- [Configuration](#configuration)

## Requirements
Mantle has two system requirements to run: PHP to be at least running 7.3 and
WordPress to be at least 5.4.

In the future, unit tests will be run using SQLite instead of MySQL. To support
SQLite, PHP needs to have the PDO extension with the SQlite driver installed. In
the event those requirements aren't met, Mantle will fall back to MySQL.

## Installing a new Mantle Site

Mantle sites should live in `wp-content/private/{site-slug}/` inside a WordPress
project. You can install a Mantle site using Composer, replacing `my-site` with
your site slug. Be sure that you've created `wp-content/private/` in your
WordPress installation first:

```bash
cd wp-content/private/
composer create-project alleyinteractive/mantle-site my-site \
--repository="{\"url\": \"https://github.com/alleyinteractive/mantle-site.git\", \"type\": \"vcs\"}" \
--remove-vcs --stability=dev --no-cache --no-interaction
```

_Note: In the future, we'll create a command to simplify this, so creating a site will be as
easy as `mantle new <site>`._

## Configuration
Mantle should be loaded through a `mu-plugin`, `client-mu-plugin`, or other
initialization script as a plugin. To ensure that all features work correctly,
Mantle should be loaded before the `muplugins_loaded` action is fired.
