# Installation

[[toc]]

## Requirements

Mantle has two system requirements to run: PHP to be at least running 7.4 and
WordPress to be at least 5.6.

## Installing Mantle on a Site

Mantle sites should live in `wp-content/plugins/{site-slug}/` inside a WordPress
project.

### Via Mantle Installer

The Mantle Installer can install Mantle on a new or existing WordPress
application. Download the Mantle installer using
[Composer](https://getcomposer.org/).

```bash
composer global require alleyinteractive/mantle-installer
```

Once installed the `mantle new` command will create a fresh Mantle installation
wherever you specify. It can also install WordPress for you or install Mantle
into an existing WordPress installation.

```bash
mantle new my-site
```

::: details Looking to contribute to Mantle?

You can install Mantle and the Mantle Framework linked to each other for easy
local development. Both will be cloned as Git repositories. Mantle Framework
will be locally checked out to `plugins/mantle-framework`.

```bash
mantle new my-site --setup-dev
```

:::

### Via Composer Create-Project

Alternatively, you can install a Mantle site using Composer, replacing `my-site`
with your site's slug.

```bash
cd wp-content/plugins/
composer create-project alleyinteractive/mantle my-site \
--remove-vcs --stability=dev --no-cache --no-interaction
```

## Use `create-mantle-app`

The [`create-mantle-app`](https://github.com/alleyinteractive/create-mantle-app)
can be used as a GitHub template for a starter template for your next
application. It is a `/wp-content/`-rooted application template that already has
Mantle installed as a plugin.

## Configuration

Mantle should be loaded through a `mu-plugin`, `client-mu-plugin`, or another
initialization script as a plugin. To ensure that all features work correctly,
Mantle should be loaded before the `muplugins_loaded` action is fired.
