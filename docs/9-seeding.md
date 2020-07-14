Database Seeding
================

# Introduction
Mantle includes a seeding and factory framework to allow you to quickly get test data in your application. All seeders live in the `database/seeds` folder of the application. The application includes a `Database_Seeder` class by default which can be used to call additional seeders.


# Writing a Seeder
```bash
wp mantle make:seeder Class_Name
```

## Seed Data Using Factories
You can use a factory to generate many instances of a model. Once you have defined a factory for a model you can use the factory to quickly pump out data for your application.

```php
/**
 * Run the database seeds.
 */
public function run() {
		factory( \App\User::class, 50 )
			->create()
			->each
			->save();
}
```

## Calling Seeders
By default the seeder command will invoke the `Database_Seeder` class in the application. You can specify a different seeder to run by specifying the `--class` flag.

```bash
wp mantle db:seed --class
```

## Calling Additional Seeders
Within a seeder you can use the `call` method to invoke additional seeders. Using the `call` method allows you to break up your database seeding into multiple files so that no single seeder class becomes overwhelmingly large. Pass the name of the seeder class you wish to run.

```php
/**
 * Run the database seeds.
 */
public function run() {
    $this->call( [
        User_Seeder::class,
        Post_Seeder::class,
        Comment_Seeder::class,
    ] );
}
```
