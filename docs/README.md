Documentation
=============

Mantle is a framework for building large, robust websites and applications with WordPress. Mantle extends WordPress Core and acts as a layer between WordPress and your custom code, aimed at helping you write more structured, testable, DRY, clean code, and doing so more quickly.

## Goals and Philosophy
Mantle is a heavily Laravel-inspired framework for improving the WordPress developer experience. It aims to make the development process delightful for the developer. WordPress can already accomplish great things out of the box. Mantle aims to make it easier and simpler to use. Code should be fluent, reusable, easy to read, and delightful to work with.

## Installing a new Mantle Site

Mantle sites should live in `wp-content/private/{site-slug}/`. You can install
a Mantle site using Composer, replacing `my-site` with your site slug. Be sure
that you've created `wp-content/private/` in your WordPress installation first:

```bash
cd wp-content/private/
composer create-project alleyinteractive/mantle-site my-site \
--repository="{\"url\": \"https://github.com/alleyinteractive/mantle-site.git\", \"type\": \"vcs\"}" \
--remove-vcs --stability=dev --no-cache --no-interaction
```

_Note: In the future, we'll create a command to simplify this, so creating a site will be as
easy as `mantle new <site>`.

## Directory Structure

Below is the current proposed directory structure for sites using Mantle. This
will certainly change and expand as Mantle develops.

```
.
├── README.md
├── app
│   ├── console
│   │   └── class-example-command.php
│   ├── jobs
│   │   └── class-example-job.php
│   ├── models
│   │   └── class-example-post.php
│   └── providers
│       └── class-app-service-provider.php
├── bootstrap
│   └── app.php
├── composer.json
├── config
│   └── app.php
├── database
│   └── factories
│       └── example-post-factory.php
├── routes
│   ├── cli.php
│   ├── rest-api.php
│   └── web.php
└── tests
    ├── class-test-case.php
    ├── feature
    │   └── test-example.php
    └── unit
        └── test-example.php
```
