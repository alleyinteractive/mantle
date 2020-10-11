# Mantle

## Installing a new Mantle Site

Mantle sites should live in `wp-content/plugins/{site-slug}/`. You can install
a Mantle site using Composer, replacing `my-site` with your site slug. Download the Mantle installer using [Composer](https://getcomposer.org/).

```bash
composer global require alleyinteractive/mantle-installer
```

Once installed the `mantle new` command will create a fresh Mantle installation
wherever you specify. It can also install WordPress for you or install Mantle
into an existing WordPress installation.

```bash
mantle new my-site
```

## Directory Structure

Below is the current proposed directory structure for sites using Mantle. This
will certainly change and expand as Mantle develops. Note that much of this is
not included in the repository, since e.g. no models exist by default.

```
.
├── README.md
├── app
│   ├── console
│   │   └── class-example-command.php
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
