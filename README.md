# Mantle

<p align="center">
	<img src="https://d33wubrfki0l68.cloudfront.net/3bdfe485d84d4032b73fbb0b06cb0db6be881eee/79a09/logo.svg" width="400" alt="Mantle" />
</p>

<p align="center">
	<a href="https://packagist.org/packages/alleyinteractive/mantle-framework">
		<img src="https://img.shields.io/packagist/v/alleyinteractive/mantle-framework.svg?style=flat-square" alt="Latest Version on Packagist" />
	</a>
	<a href="https://github.com/alleyinteractive/mantle/actions/workflows/tests.yml">
		<img src="https://github.com/alleyinteractive/mantle/actions/workflows/tests.yml/badge.svg" alt="Testing Suite" />
	</a>
	<a href="https://github.com/alleyinteractive/mantle/actions/workflows/coding-standards.yml">
		<img src="https://github.com/alleyinteractive/mantle/actions/workflows/coding-standards.yml/badge.svg" alt="Coding Standards" />
	</a>
</p>

<p align="center">
	Mantle is a framework for building large, robust websites and applications with WordPress.
</p>

## Background

Mantle is a framework designed to make WordPress development simpler with a more
delightful syntax. It is built for enterprise-level WordPress plugins and themes
and is inspired largely by Laravel. Mantle is designed to be a standalone plugin
that integrates well with your theme, allowing your theme to focus on the styles
and layout and leaving the rest of the functionality to be built within the
Mantle plugin.

For more information about the framework and how to get started using it, check
out the [Mantle Documentation Site](https://mantle.alley.co/).

## Installation

Mantle plugins should live in `wp-content/plugins/{site-slug}/` within a
WordPress installation. You can add a copy of Mantle to your existing WordPress
site by running the following command:

```bash
composer create-project alleyinteractive/mantle my-site \
  --remove-vcs \
  --stability=dev \
  --no-cache \
  --no-interaction
```

Alternatively, you can use the Mantle Installer package and install Mantle (and
WordPress optionally) automatically:

```bash
mantle new my-site
```

You can also use a our
[create-mantle-app](https://github.com/alleyinteractive/create-mantle-app)
starter kit to get a fully scaffolded `wp-content`-rooted WordPress project out
of the box. For more information, see
[Installation](https://mantle.alley.co/getting-started/installation.html).

## Maintainers

This project is actively maintained by [Alley
Interactive](https://github.com/alleyinteractive). Like what you see? [Come work
with us](https://alley.co/careers/).

![Alley logo](https://avatars.githubusercontent.com/u/1733454?s=200&v=4)

## License

This software is released under the terms of the GNU General Public License
version 2 or any later version.
