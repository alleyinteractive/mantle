Configuration
=============

- [Configuration](#configuration)
- [Introduction](#introduction)
	- [Getting Configuration](#getting-configuration)
	- [Environment-specific Configuration](#environment-specific-configuration)

# Introduction
Mantle provides a configuration interface to allow easy control over the
application and how it differs on each environment. The application ships with a
few configuration files in the `config/` folder.

## Getting Configuration
Configuration is possible through the `config()` helper function, the `Config`
alias, and `Mantle\Framework\Facade\Config` facade. Each method supports a "dot"
syntax which includes the name of the file and the option you wish to access.

```php
config( 'app.providers' );

Config::get( 'app.providers' );

Mantle\Framework\Facade\Config::get( 'app.providers' );
```

## Environment-specific Configuration
Environment-specific configuration is possible by including a configuration file
in a child folder named after the respective environment to apply the
configuration for.

The following is an example of a configuration value that is
only loaded on the `local` environment.

```
├── README.md
├── config
│   ├── app.php
│   ├── local
│   │   └── app.php
```

```php
// Located in config/local/app.php.
return [
	'providers' => App\Providers\Local_Service_Provider::class,
];
```
