# Directory Structure

- [Directory Structure](#directory-structure)
- [Overview](#overview)
- [Root Directory](#root-directory)
	- [The App Directory](#the-app-directory)
	- [The Bootstrap Directory](#the-bootstrap-directory)
	- [The Config Directory](#the-config-directory)
	- [The Database Directory](#the-database-directory)
	- [The Routes Directory](#the-routes-directory)
	- [The Tests Directory](#the-tests-directory)

# Overview
Below is the current proposed directory structure for sites using Mantle. This
will certainly change and expand as Mantle develops. The tree is assumed to be
placed inside of a `wp-content/private/{site}` folder.

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
│   ├── factories
│   │   └── post-factory.php
│   └── seeds
│       └── class-database-seeder.php
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

# Root Directory
## The App Directory
The `app` diretory contains the core code of your application. This includes
console commands, routes, models, providers, and more. Most of the application
will live inside of this folder. By default this folder is namespaced `App` and
autoloaded using a WordPress-style autoloader.

## The Bootstrap Directory
The `bootstrap` directory contains the `app.php` file which bootstraps and loads the
framework. It can also contain a `cache` folder which contains framework
generated files for performance optimization including routes and packages.

## The Config Directory
The `config` directory contains the application configuration. For more
information about this, read the Configuration documentation page.

## The Database Directory
The `database` directory contains the database factories and seeders used to
initialize the database for testing. For more information about this, read the
'Model Factory' documentation page.

## The Routes Directory
The `routes` directory contains all of the application's HTTP route definitions.
By default, this includes `web.php` and `rest-api.php` for web and REST API
routes, respectively.

## The Tests Directory
The `tests` directory contains the automated tests for the application powered
by PHPUnit and the Mantle Test Framework.
